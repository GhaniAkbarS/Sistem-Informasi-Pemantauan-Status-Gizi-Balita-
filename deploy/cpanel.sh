#!/usr/bin/env bash
set -euo pipefail

app=/home/sipgiziw/sip_gizi
web=/home/sipgiziw/public_html

# Stop before changing the live site if its layout or dependencies differ.
for required in "$app/.env" "$app/vendor/autoload.php" "$web/index.php"; do
  if [[ ! -f "$required" ]]; then
    echo "Required production file is missing: $required" >&2
    exit 1
  fi
done
if ! grep -q 'sip_gizi/vendor/autoload.php' "$web/index.php"; then
  echo 'Production index.php does not point to sip_gizi.' >&2
  exit 1
fi
if ! cmp -s composer.lock "$app/composer.lock"; then
  echo 'composer.lock differs from production. Update vendor dependencies before deploying.' >&2
  exit 1
fi
if [[ "${1:-}" == '--check' ]]; then
  echo 'Deployment preflight passed; no production files were changed.'
  exit 0
fi

# Copy Laravel source without replacing the production environment or storage.
cp -R app bootstrap config database resources routes "$app/"
cp artisan composer.json composer.lock "$app/"

# Keep the production front controller, rewrite rules, and uploaded files.
for item in public/*; do
  case "$item" in
    public/index.php|public/hot|public/storage) continue ;;
  esac
  cp -R "$item" "$web/"
done

cd "$app"
php artisan optimize:clear
php artisan migrate --force
