const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');

test('titik hanya pada pemeriksaan dan tooltip memuat hasil serta acuan', () => {
  let renderedOptions;
  class ApexCharts {
    constructor(_element, options) { renderedOptions = options; }
    render() {}
  }
  const window = { ApexCharts };
  const document = { createElement: () => ({ style: {}, className: '', id: '' }) };
  const source = fs.readFileSync(path.join(__dirname, '../../public/tabler/js/sip-chart-compat.js'), 'utf8');
  vm.runInNewContext(source, { window, document, ApexCharts });

  const canvas = {
    id: 'grafikBBU', style: {}, getAttribute: () => null,
    insertAdjacentElement: () => {},
  };
  new window.Chart(canvas, {
    type: 'line',
    data: {
      labels: [0, 1, 2],
      datasets: [
        { label: 'Acuan', data: [3, 4, 5], pointRadius: 0 },
        { label: 'Anak', data: [null, 4.2, null], pointRadius: 6 },
      ],
    },
  });

  assert.equal(renderedOptions.markers.size, 0);
  assert.deepEqual(Array.from(renderedOptions.markers.discrete, marker => [marker.seriesIndex, marker.dataPointIndex, marker.size]), [[1, 1, 6]]);
  assert.equal(renderedOptions.tooltip.shared, true);
  assert.equal(renderedOptions.tooltip.custom({ dataPointIndex: 0 }), '');
  const popup = renderedOptions.tooltip.custom({ dataPointIndex: 1 });
  assert.match(popup, /Acuan: <strong>4<\/strong>/);
  assert.match(popup, /Anak: <strong>4\.2<\/strong>/);
});
