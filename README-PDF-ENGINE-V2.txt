Morten Portfolio - PDF Engine v2
================================

Denne versjonen bygger en separat A4-layout i en skjult iframe.

Viktige endringer:
- Ingen popup-vindu.
- /cv/-visningen endres ikke ved utskrift.
- @page har 0 mm marg for full-bleed PDF.
- Sidebaren tegnes som et fast SVG-lag fra øvre til nedre papirkant.
- Hovedinnholdet har egen sikker topp-/bunnpadding.
- PDF-footeren legges etter siste CV-seksjon og vises kun én gang.
- Dato, klokkeslett og innlogget bruker settes når knappen trykkes.
- Automatisk kompakt/tett layout reduserer unødvendig mange sider.

Merk om fysisk utskrift:
PDF-filen får full-bleed sidebar. En fysisk skriver må støtte kantløs utskrift for å
kunne skrive helt til papirkanten. Ellers vil skriverdriveren legge inn sin egen kant.
