/**
 * CV PDF Engine v2.
 *
 * Builds an isolated A4 document in a hidden same-origin iframe. The browser
 * CV is never restyled. The PDF document uses a zero-margin page box and a
 * fixed SVG layer for a true edge-to-edge sidebar in exported PDFs.
 */
document.addEventListener('DOMContentLoaded', () => {
  const button = document.getElementById('pdfButton');
  const shell = document.querySelector('.cv-shell');
  const sourceDocument = document.querySelector('.cv-document');
  const pdfStyle = shell?.dataset.cvStyle || 'modern';
  const pdfLanguage = shell?.dataset.cvLanguage || 'no';

  if (!button || !shell || !sourceDocument) return;

  const formatGeneratedAt = (date) => new Intl.DateTimeFormat('nb-NO', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
  }).format(date);

  const escapeHtml = (value) => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

  const printCss = `
    :root {
      --green-dark: #123f2c;
      --green: #3f7f36;
      --olive: #8da62e;
      --green-light: #edf5ea;
      --border: #dce6d8;
      --muted: #667064;
      --sidebar-width: 56mm;
      --page-width: 210mm;
      --page-height: 297mm;
    }

    @page {
      size: A4 portrait;
      margin: 0;
    }

    * { box-sizing: border-box; }

    html,
    body {
      width: var(--page-width);
      margin: 0;
      padding: 0;
      background: #fff;
      color: #183728;
      font-family: Arial, Helvetica, sans-serif;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    body { overflow: visible; }
    body.pdf-style-minimal .cv-section h2 { border-bottom-width: .25mm; }
    body.pdf-style-minimal .cv-role-marker, body.pdf-style-minimal .cv-entry-marker { display:none !important; }
    body.pdf-style-minimal .cv-header h1 { font-weight:700; }
    body.pdf-style-executive .cv-header h1 { font-family: Georgia, 'Times New Roman', serif; letter-spacing:-.02em; }
    body.pdf-style-executive .cv-section h2 { letter-spacing:.13em; }
    body.pdf-style-executive .cv-employer-name { font-family: Georgia, 'Times New Roman', serif; }

    /* An SVG image is used instead of a CSS background. Images are retained
       by Chromium's PDF output even when background graphics are disabled. */
    .pdf-bleed-sidebar {
      position: fixed;
      z-index: 0;
      inset: 0 auto auto 0;
      width: var(--sidebar-width);
      height: var(--page-height);
      pointer-events: none;
    }

    .pdf-document,
    .cv-document {
      position: relative;
      z-index: 1;
      display: block;
      width: var(--page-width);
      margin: 0;
      padding: 0;
      overflow: visible;
      background: transparent;
      border: 0;
      border-radius: 0;
      box-shadow: none;
    }

    .cv-sidebar {
      position: absolute;
      top: 0;
      left: 0;
      width: var(--sidebar-width);
      padding: 10mm 5mm 9mm;
      background: transparent;
      border: 0;
    }

    .portrait-ring {
      display: grid;
      width: 30mm;
      height: 30mm;
      margin: 0 auto 5mm;
      padding: 1mm;
      place-items: center;
      border: .25mm solid var(--border);
      border-radius: 50%;
      background: #fff;
    }

    .portrait-ring.portrait-missing::after {
      content: "MH";
      color: var(--green);
      font-size: 18pt;
      font-weight: 900;
    }

    .portrait {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }

    .contact-list {
      margin-bottom: 4mm;
      border-top: .25mm solid var(--border);
    }

    .contact-row {
      display: grid;
      grid-template-columns: 4mm minmax(0, 1fr);
      gap: 2mm;
      padding: 1.8mm 0;
      border-bottom: .25mm solid var(--border);
      break-inside: avoid;
    }

    .contact-row p,
    .sidebar-section li,
    .sidebar-section p {
      margin: 0;
      color: var(--muted);
      font-size: 7.1pt;
      line-height: 1.28;
      overflow-wrap: anywhere;
    }

    .contact-row a { color: inherit; text-decoration: none; }

    .sidebar-section {
      margin-top: 3.6mm;
      break-inside: avoid;
    }

    .sidebar-section h3 {
      margin: 0 0 1.8mm;
      color: var(--green-dark);
      font-size: 7.4pt;
      line-height: 1.2;
      letter-spacing: .07em;
      text-transform: uppercase;
    }

    .sidebar-section ul {
      display: grid;
      gap: 1mm;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .sidebar-section li {
      position: relative;
      padding-left: 3mm;
    }

    .sidebar-section li::before {
      content: "";
      position: absolute;
      top: .48em;
      left: 0;
      width: 1.1mm;
      height: 1.1mm;
      border-radius: 50%;
      background: var(--olive);
    }

    .language {
      display: grid;
      grid-template-columns: 14mm 1fr 7mm;
      gap: 1.4mm;
      align-items: center;
      margin-bottom: 1.4mm;
      font-size: 7pt;
    }

    .language i {
      position: relative;
      height: 1.4mm;
      border-radius: 99mm;
      background: rgba(63,127,54,.15);
    }

    .language i::after {
      content: "";
      position: absolute;
      inset: 0 auto 0 0;
      width: var(--p);
      border-radius: inherit;
      background: linear-gradient(90deg, var(--green), var(--olive));
    }

    .language b { color: var(--muted); text-align: right; }

    .cv-main {
      width: calc(var(--page-width) - var(--sidebar-width));
      margin-left: var(--sidebar-width);
      padding: 10mm 10mm 10mm 9mm;
      background: #fff;
      -webkit-box-decoration-break: clone;
      box-decoration-break: clone;
    }

    .cv-header {
      margin: 0 0 5mm;
      padding: 0 0 3.5mm;
      border-bottom: .35mm solid var(--border);
      break-after: avoid;
    }

    .cv-kicker {
      margin: 0 0 1.7mm;
      color: var(--olive);
      font-size: 7.4pt;
      font-weight: 800;
      letter-spacing: .14em;
      text-transform: uppercase;
    }

    .cv-header h1 {
      margin: 0;
      color: var(--green-dark);
      font-size: 25pt;
      line-height: 1;
      letter-spacing: -.04em;
    }

    .cv-section { margin-top: 5mm; }
    .cv-section:first-of-type { margin-top: 0; }

    .cv-section h2 {
      margin: 0 0 3.2mm;
      padding: 0 0 1.7mm;
      border-bottom: .55mm solid var(--green-light);
      color: var(--green-dark);
      font-size: 8.8pt;
      line-height: 1.2;
      letter-spacing: .08em;
      text-transform: uppercase;
      break-after: avoid;
    }

    .cv-employer-timeline { display: grid; gap: 3.7mm; }
    .cv-employer-group { break-inside: auto; }
    .cv-employer-group-compact { break-inside: avoid; }

    .cv-employer-name {
      margin: 0 0 1.7mm;
      color: var(--green-dark);
      font-size: 8.8pt;
      line-height: 1.2;
      break-after: avoid;
    }

    .cv-role-list { position: relative; display: grid; gap: 2.2mm; }

    .has-multiple-roles .cv-role-list {
      margin-left: 1mm;
      padding-left: 4mm;
    }

    .has-multiple-roles .cv-role-list::before {
      content: "";
      position: absolute;
      top: 1.5mm;
      bottom: 1.5mm;
      left: 0;
      width: .45mm;
      background: #dce7d5;
    }

    .cv-role-entry,
    .cv-entry {
      position: relative;
      break-inside: avoid;
    }

    .cv-role-marker { display: none; }

    .has-multiple-roles .cv-role-marker {
      display: block;
      position: absolute;
      z-index: 1;
      top: 1.3mm;
      left: -5.05mm;
      width: 2mm;
      height: 2mm;
      border: .45mm solid #fff;
      border-radius: 50%;
      background: var(--olive);
      box-shadow: 0 0 0 .35mm #dce7d5;
    }

    .cv-entry-head { display: block; }

    .cv-role-entry h4,
    .cv-entry h3 {
      margin: 0;
      color: var(--green-dark);
      font-size: 8.3pt;
      line-height: 1.23;
      break-after: avoid;
    }

    .cv-entry-period {
      margin: .55mm 0 0;
      color: var(--muted);
      font-size: 7.05pt;
      line-height: 1.2;
      font-weight: 700;
    }

    .cv-entry-company {
      margin: .6mm 0 0;
      color: var(--olive);
      font-size: 7.1pt;
      font-weight: 750;
    }

    .cv-entry-content {
      margin-top: 1mm;
      color: var(--muted);
      font-size: 7.55pt;
      line-height: 1.28;
    }

    .cv-entry-content p { margin: 0; }

    .cv-timeline {
      position: relative;
      display: grid;
      gap: 2.5mm;
      padding-left: 5mm;
    }

    .cv-timeline::before {
      content: "";
      position: absolute;
      top: 1.5mm;
      bottom: 1.5mm;
      left: .7mm;
      width: .45mm;
      background: #dce7d5;
    }

    .cv-entry-marker {
      position: absolute;
      z-index: 1;
      top: 1.2mm;
      left: -5.15mm;
      width: 2.1mm;
      height: 2.1mm;
      border: .45mm solid #fff;
      border-radius: 50%;
      background: var(--olive);
      box-shadow: 0 0 0 .35mm #dce7d5;
    }

    .pdf-footer {
      margin-top: 4mm;
      padding-top: 2.3mm;
      border-top: .3mm solid #cfdac8;
      color: #64705f;
      font-size: 6.7pt;
      line-height: 1.25;
      break-inside: avoid;
    }

    .pdf-footer-inner {
      display: flex;
      justify-content: space-between;
      gap: 8mm;
    }

    /* Automatic density levels are selected after layout measurement. */
    body.pdf-density-compact .cv-main { padding-top: 8mm; padding-bottom: 8mm; }
    body.pdf-density-compact .cv-header { margin-bottom: 4mm; padding-bottom: 3mm; }
    body.pdf-density-compact .cv-section { margin-top: 4mm; }
    body.pdf-density-compact .cv-employer-timeline { gap: 3mm; }
    body.pdf-density-compact .cv-role-list { gap: 1.8mm; }
    body.pdf-density-compact .cv-entry-content { font-size: 7.25pt; line-height: 1.24; }

    body.pdf-density-tight .cv-main { padding-top: 7mm; padding-bottom: 7mm; }
    body.pdf-density-tight .cv-header { margin-bottom: 3.4mm; padding-bottom: 2.6mm; }
    body.pdf-density-tight .cv-header h1 { font-size: 23pt; }
    body.pdf-density-tight .cv-section { margin-top: 3.4mm; }
    body.pdf-density-tight .cv-section h2 { margin-bottom: 2.6mm; }
    body.pdf-density-tight .cv-employer-timeline { gap: 2.5mm; }
    body.pdf-density-tight .cv-role-list { gap: 1.5mm; }
    body.pdf-density-tight .cv-entry-content { font-size: 7pt; line-height: 1.2; }
    body.pdf-density-tight .pdf-footer { margin-top: 3mm; }

    a { color: inherit; text-decoration: none; }
  `;

  const buildPrintDocument = () => {
    const viewer = shell.dataset.cvViewer?.trim() || 'Ukjent bruker';
    const generatedAt = formatGeneratedAt(new Date());
    const clone = sourceDocument.cloneNode(true);

    clone.querySelectorAll('[id]').forEach((element) => element.removeAttribute('id'));
    clone.classList.add('pdf-cv-clone');

    const main = clone.querySelector('.cv-main');
    if (main) {
      main.insertAdjacentHTML('beforeend', `
        <footer class="pdf-footer">
          <div class="pdf-footer-inner">
            <span>Generert av <strong>${escapeHtml(viewer)}</strong></span>
            <span>Generert ${escapeHtml(generatedAt)}</span>
          </div>
        </footer>
      `);
    }

    const title = document.title || 'CV';
    return `<!doctype html>
      <html lang="nb">
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>${escapeHtml(title)}</title>
          <style>${printCss}</style>
        </head>
        <body class="pdf-style-${escapeHtml(pdfStyle)}">
          <svg class="pdf-bleed-sidebar" viewBox="0 0 560 2970" preserveAspectRatio="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="0" width="557" height="2970" fill="#edf5ea"/>
            <rect x="557" y="0" width="3" height="2970" fill="#dce6d8"/>
          </svg>
          <main class="pdf-document">${clone.outerHTML}</main>
        </body>
      </html>`;
  };

  const removeOldFrame = () => {
    const oldFrame = document.getElementById('cvPrintFrame');
    if (oldFrame) oldFrame.remove();
  };

  const waitForAssets = async (frameWindow, frameDocument) => {
    const images = Array.from(frameDocument.images);
    await Promise.all(images.map((image) => image.complete
      ? Promise.resolve()
      : new Promise((resolve) => {
          image.addEventListener('load', resolve, { once: true });
          image.addEventListener('error', resolve, { once: true });
        })
    ));

    if (frameDocument.fonts?.ready) await frameDocument.fonts.ready;

    await new Promise((resolve) => frameWindow.requestAnimationFrame(() =>
      frameWindow.requestAnimationFrame(resolve)
    ));
  };

  const applyAutomaticDensity = (frameDocument) => {
    const main = frameDocument.querySelector('.cv-main');
    if (!main) return;

    // A4 at 96 CSS px/inch is approximately 1122.5 px high. The thresholds
    // keep typical CVs to two or three pages without sacrificing readability.
    const pageHeightPx = 1122.5;
    const estimatedPages = main.scrollHeight / pageHeightPx;

    if (estimatedPages > 3.05) {
      frameDocument.body.classList.add('pdf-density-tight');
    } else if (estimatedPages > 2.15) {
      frameDocument.body.classList.add('pdf-density-compact');
    }
  };

  const openPrintDocument = async () => {
    removeOldFrame();

    const originalLabel = button.textContent;
    button.disabled = true;
    button.textContent = pdfLanguage === 'en' ? 'Preparing PDF …' : 'Klargjør PDF …';

    const frame = document.createElement('iframe');
    frame.id = 'cvPrintFrame';
    frame.title = 'Utskriftsvisning for CV';
    frame.setAttribute('aria-hidden', 'true');
    frame.style.position = 'fixed';
    frame.style.right = '0';
    frame.style.bottom = '0';
    frame.style.width = '1px';
    frame.style.height = '1px';
    frame.style.border = '0';
    frame.style.opacity = '0';
    frame.style.pointerEvents = 'none';
    document.body.appendChild(frame);

    const frameWindow = frame.contentWindow;
    const frameDocument = frame.contentDocument || frameWindow?.document;

    if (!frameWindow || !frameDocument) {
      frame.remove();
      button.disabled = false;
      button.textContent = originalLabel;
      window.alert('Kunne ikke opprette PDF-visningen. Last siden på nytt og prøv igjen.');
      return;
    }

    try {
      frameDocument.open();
      frameDocument.write(buildPrintDocument());
      frameDocument.close();

      await waitForAssets(frameWindow, frameDocument);
      applyAutomaticDensity(frameDocument);
      await waitForAssets(frameWindow, frameDocument);

      const cleanup = () => {
        window.setTimeout(() => frame.remove(), 400);
        button.disabled = false;
        button.textContent = originalLabel;
      };

      frameWindow.addEventListener('afterprint', cleanup, { once: true });
      frameWindow.focus();
      frameWindow.print();

      // Fallback for browsers that do not dispatch afterprint for iframes.
      window.setTimeout(() => {
        if (document.body.contains(frame)) frame.remove();
        button.disabled = false;
        button.textContent = originalLabel;
      }, 60000);
    } catch (error) {
      frame.remove();
      button.disabled = false;
      button.textContent = originalLabel;
      window.alert('PDF-visningen kunne ikke klargjøres. Last siden på nytt og prøv igjen.');
    }
  };

  button.addEventListener('click', openPrintDocument);
});
