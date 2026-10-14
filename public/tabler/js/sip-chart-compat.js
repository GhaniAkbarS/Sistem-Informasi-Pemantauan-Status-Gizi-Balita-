/*
 * Small bridge for the existing growth-chart configuration.
 * Rendering is provided by Tabler's bundled ApexCharts, not Chart.js.
 */
(() => {
  class Chart {
    static defaults = { global: {} };

    constructor(context, config) {
      this.config = config;
      this.data = config.data;
      const canvas = context && context.canvas ? context.canvas : context;
      if (!canvas || !window.ApexCharts) return;
      this.element = document.createElement('div');
      this.element.id = canvas.id + '-apex';
      this.element.className = 'sip-apex-chart';
      this.element.style.minHeight = Math.max(Number(canvas.getAttribute('height')) || 0, 240) + 'px';
      this.canvas = canvas;
      canvas.style.display = 'none';
      canvas.insertAdjacentElement('afterend', this.element);
      this.chart = new ApexCharts(this.element, this.options());
      this.chart.render();
    }

    options() {
      const config = this.config;
      const data = this.data || { labels: [], datasets: [] };
      const datasets = data.datasets || [];
      const doughnut = config.type === 'doughnut';
      const horizontal = config.type === 'horizontalBar';
      const type = doughnut ? 'donut' : horizontal ? 'bar' : 'line';
      const colors = doughnut
        ? (datasets[0]?.backgroundColor || ['#2c8066', '#bb3653'])
        : horizontal
          ? (datasets[0]?.backgroundColor || ['#c2185b'])
          : datasets.map(item => item.borderColor || item.backgroundColor || '#c2185b');
      const series = doughnut
        ? (datasets[0]?.data || []).map(Number)
        : datasets.map(item => ({ name: item.label || ' ', data: item.data || [] }));
      const referenceSeries = !doughnut && !horizontal && datasets.some(item => item.pointRadius === 0);
      const examinationSeries = datasets.flatMap((item, index) =>
        item.pointRadius === 0 ? [] : [index]
      );
      const examinationMarkers = referenceSeries
        ? datasets.flatMap((item, seriesIndex) =>
            item.pointRadius === 0 ? [] : (item.data || []).flatMap((value, dataPointIndex) =>
              value === null || value === undefined || value === '' ? [] : [{
                seriesIndex,
                dataPointIndex,
                size: item.pointRadius ?? 5,
                fillColor: item.borderColor || '#c2185b',
                strokeColor: '#ffffff',
              }]
            )
          )
        : [];
      const growthTooltip = ({ dataPointIndex }) => {
        const value = datasets[examinationSeries[0]]?.data?.[dataPointIndex];
        if (value === null || value === undefined || value === '') return '';
        const escape = text => String(text).replace(/[&<>"']/g, character => ({
          '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        })[character]);
        const rows = datasets.map((item, index) => {
          const point = item.data?.[dataPointIndex];
          if (!item.label || point === null || point === undefined || point === '') return '';
          const color = escape(colors[index]);
          return `<div style="display:flex;align-items:center;gap:8px;margin-top:6px">
            <span style="width:10px;height:10px;border-radius:50%;background:${color};flex:none"></span>
            <span>${escape(item.label)}: <strong>${escape(point)}</strong></span>
          </div>`;
        }).join('');
        return `<div style="background:#fff;color:#222;padding:10px 12px;border:1px solid #ddd;border-radius:6px;box-shadow:0 4px 16px #0002">
          <strong>${escape(data.labels?.[dataPointIndex] ?? '')}</strong>${rows}
        </div>`;
      };
      const height = Math.max(Number(this.element?.style.minHeight.replace('px', '')) || 240, 240);
      const base = {
        chart: { type, height, fontFamily: 'inherit', toolbar: { show: false }, animations: { enabled: false } },
        series,
        colors,
        dataLabels: { enabled: false },
        legend: { show: !horizontal && (doughnut || datasets.length > 1), position: 'bottom', labels: { useSeriesColors: false } },
        tooltip: referenceSeries
          ? { shared: true, intersect: false, custom: growthTooltip }
          : { shared: !doughnut, intersect: false },
        grid: { borderColor: '#ecdde5' }
      };
      if (doughnut) {
        base.labels = data.labels || [];
        base.plotOptions = { pie: { donut: { size: '72%' } } };
      } else {
        base.xaxis = { categories: data.labels || [], title: { text: config.options?.scales?.x?.title?.text || '' } };
        base.yaxis = { title: { text: config.options?.scales?.y?.title?.text || '' }, decimalsInFloat: 1 };
        base.stroke = { width: horizontal ? 0 : datasets.map(item => item.borderWidth || 2), curve: 'smooth' };
        base.markers = {
          size: horizontal || referenceSeries ? 0 : 3,
          discrete: examinationMarkers,
          hover: { sizeOffset: 0 }
        };
        if (horizontal) base.plotOptions = { bar: { horizontal: true, distributed: true, borderRadius: 3 } };
        if (datasets.some(item => item.yAxisID)) {
          base.yaxis = datasets.map((item, index) => ({
            seriesName: item.label,
            opposite: index > 0,
            title: { text: item.label }
          }));
        }
      }
      return base;
    }

    update() {
      if (!this.chart) return;
      this.chart.updateOptions(this.options(), false, false);
    }

    destroy() {
      if (this.chart) this.chart.destroy();
      if (this.element) this.element.remove();
      if (this.canvas) this.canvas.style.display = '';
    }
  }
  window.Chart = Chart;
})();
