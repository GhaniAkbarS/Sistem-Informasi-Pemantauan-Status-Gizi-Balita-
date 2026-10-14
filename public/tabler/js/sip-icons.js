/* Tabler-style outline icons for the application navigation and legacy icon slots. */
(() => {
  const paths = {
    heart: '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8z"/>',
    baby: '<circle cx="12" cy="12" r="9"/><path d="M9 10h.01M15 10h.01M9 15c2 2 4 2 6 0M10 3c0 2 1 3 3 3"/>',
    menu: '<path d="M4 6h16M4 12h16M4 18h16"/>',
    home: '<path d="M3 10l9-7 9 7v10H3zM9 20v-7h6v7"/>',
    dashboard: '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 9v12"/>',
    users: '<circle cx="9" cy="8" r="3"/><path d="M3 20v-2a6 6 0 0 1 12 0v2M16 5a3 3 0 0 1 0 6M18 14a5 5 0 0 1 3 5v1"/>',
    'user-group': '<circle cx="8" cy="8" r="3"/><circle cx="17" cy="9" r="2.5"/><path d="M2 20v-2a6 6 0 0 1 12 0v2M16 15a5 5 0 0 1 6 5"/>',
    user: '<circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/>',
    calendar: '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4M17 3v4M3 10h18"/>',
    stethoscope: '<path d="M6 4v7a4 4 0 0 0 8 0V4M4 4h4M12 4h4M10 15v1a5 5 0 0 0 10 0v-3"/><circle cx="20" cy="11" r="2"/>',
    vaccine: '<path d="M4 20l4-4M13 3l8 8M11 5l8 8M7 9l8 8M9 7l8 8M5 11l8 8M3 21l3-3"/>',
    pill: '<path d="M8 20a5 5 0 0 1-4-8l8-8a5 5 0 0 1 7 7l-8 8a5 5 0 0 1-3 1zM8 8l8 8"/>',
    report: '<path d="M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zM15 3v5h5M8 13h8M8 17h8"/>',
    settings: '<circle cx="12" cy="12" r="3"/><path d="M10 2h4l1 3 2 1 3-1 2 4-2 2v2l2 2-2 4-3-1-2 1-1 3h-4l-1-3-2-1-3 1-2-4 2-2v-2L2 9l2-4 3 1 2-1z"/>',
    check: '<circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/>',
    alert: '<path d="M12 3L2 21h20L12 3zM12 9v5M12 18h.01"/>',
    close: '<circle cx="12" cy="12" r="9"/><path d="M9 9l6 6M15 9l-6 6"/>',
    clock: '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    refresh: '<path d="M20 7a8 8 0 0 0-14-2L4 7M4 3v4h4M4 17a8 8 0 0 0 14 2l2-2M20 21v-4h-4"/>',
    chart: '<path d="M3 3v18h18M7 16v-4M12 16V7M17 16v-6"/>',
    list: '<path d="M9 6h12M9 12h12M9 18h12M4 6h.01M4 12h.01M4 18h.01"/>',
    play: '<path d="M8 4l12 8-12 8z"/>',
    print: '<path d="M6 9V3h12v6M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 15h12v6H6z"/>',
    route: '<circle cx="5" cy="5" r="2"/><circle cx="19" cy="19" r="2"/><path d="M7 5h9a4 4 0 0 1 0 8H8a4 4 0 0 0 0 6h9"/>',
    trash: '<path d="M4 7h16M8 7V4h8v3M6 7l1 14h10l1-14M10 11v6M14 11v6"/>',
    flask: '<path d="M9 3h6M10 3v7L4 20a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1l-6-10V3M8 16h8"/>',
    info: '<circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/>',
    circle: '<circle cx="12" cy="12" r="7"/>'
  };
  const faMap = {
    'fa-baby':'baby','fa-bars':'menu','fa-calendar-alt':'calendar','fa-capsules':'pill',
    'fa-chart-bar':'chart','fa-check-circle':'check','fa-circle':'circle','fa-clock':'clock',
    'fa-exclamation-triangle':'alert','fa-file-alt':'report','fa-flask':'flask','fa-home':'home',
    'fa-info-circle':'info','fa-list-check':'list','fa-list-ol':'list','fa-play':'play',
    'fa-print':'print','fa-route':'route','fa-stethoscope':'stethoscope','fa-syringe':'vaccine',
    'fa-tachometer-alt':'dashboard','fa-tasks':'list','fa-times-circle':'close','fa-trash':'trash',
    'fa-undo':'refresh','fa-user':'user','fa-user-circle':'user','fa-user-friends':'user-group','fa-users':'users'
  };
  function replace(node, name) {
    const wrapper = document.createElement('span');
    wrapper.className = 'sip-icon' + (node.classList.contains('fa-3x') || node.classList.contains('fa-2x') ? ' icon-lg' : '');
    for (const cls of node.classList) {
      if (!cls.startsWith('fa-') && cls !== 'fas' && cls !== 'far' && cls !== 'fab') wrapper.classList.add(cls);
    }
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('viewBox', '0 0 24 24');
    svg.setAttribute('fill', 'none');
    svg.setAttribute('stroke', 'currentColor');
    svg.setAttribute('stroke-width', '1.8');
    svg.setAttribute('stroke-linecap', 'round');
    svg.setAttribute('stroke-linejoin', 'round');
    svg.setAttribute('aria-hidden', 'true');
    svg.innerHTML = paths[name] || paths.circle;
    wrapper.appendChild(svg);
    node.replaceWith(wrapper);
  }
  function apply(root = document) {
    root.querySelectorAll('[data-sip-icon]').forEach(node => replace(node, node.dataset.sipIcon));
    root.querySelectorAll('i[class*="fa-"]').forEach(node => {
      const iconClass = [...node.classList].find(cls => faMap[cls]);
      replace(node, faMap[iconClass] || 'circle');
    });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', () => apply());
  else apply();
  window.sipApplyIcons = apply;
})();
