NY LAGRE SOM PDF-FUNKSJON
=========================

Denne versjonen bygger PDF-visningen i et separat utskriftsvindu. Nettleser-CV-en
endres ikke. Utskriftsvinduet bruker en egen A4-layout som:

- kloner det faktiske innholdet som vises på /cv/
- beholder portrett, sidebar, typografi, farger og tidslinjer
- komprimerer innholdet kontrollert for færre sider
- lar seksjonene flyte naturlig uten kunstige tomme sider
- viser genereringsnavn, dato og klokkeslett kun én gang etter siste seksjon
- tegner en fast lysegrønn sidebakgrunn på alle PDF-sider

Viktig i utskriftsdialogen:
- Destinasjon: Lagre som PDF
- Papirstørrelse: A4
- Skala: 100 %
- Marger: Standard eller Ingen (CSS styrer sideoppsettet)
- Bakgrunnsgrafikk: aktivert for helt korrekt fargegjengivelse
