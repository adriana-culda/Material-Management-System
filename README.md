# Material-Management-System
Sistem de gestiune a materialelor bazat pe interfață web, dezvoltat în PHP și MySQL. Acest proiect este o aplicație de tip **Inventory Tracker** care permite monitorizarea eficientă a materialelor. Utilizatorul poate vizualiza detaliile fiecărui produs, locația în care se află și prețul acestuia, având la dispoziție instrumente de filtrare rapidă.

**Funcționalități**
* **Căutare live:** Filtrarea materialelor după nume sau locație.
* **Sortare dinamică:** Ordonarea tabelului după orice coloană (ID, Preț, Dată etc.).
* **Relaționare SQL:** Corelare automată între materiale și depozite (locații).
* **Interfață Responsivă:** Design curat realizat cu Bootstrap.

**Tehnologii Utilizate**
* **Limbaj:** PHP
* **Bază de date:** MySQL
* **Frontend:** HTML, CSS, Bootstrap
* **Server recomandat:** XAMPP

**Structura Bazei de Date**

Proiectul necesită două tabele corelate:
1. `locatii` - gestionează punctele de depozitare.
2. `materiale` - conține detaliile tehnice și financiare ale produselor.


