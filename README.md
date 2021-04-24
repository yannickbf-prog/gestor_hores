# Gestor d'hores

## Documentació

2.3.1 Validar usuari

    • Actor principal: Administrador
    • Actor secundari: Treballador
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Entrar a l’apartat de login de la pagina web
    • Fer login
    • Que l’usuari que fas servir per fer login estigui donat d’alta
    • Postcondicionaments
    • En el cas de fer login com administrador hauries de veure el panell de control de l’administrador en el cas de ser treballador hauries de veure el panell de control del treballador.
    • Escenari principal o flux bàsic
    • 1. L’administrador o treballador entren a l’apartat de login de la pagina web
    • 2. Posen el seu usuari i contrasenya a un formulari i l’envien
    • 3. Accedeixen a la pagina web d'administració corresponent al tipus d’usuari

    • Extensions (o fluxos alternatius)
    • Si l’usuari no existeix o la contrasenya no es valida no es podrà accedir al panell de control. En aquest cas es mostrara un missatge d’error a baix del formulari indicant que l’usuari no es vàlid o que l’usuari es vàlid però la contrasenya no ho es.

2.3.2 Panell de control d’administrador

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver fet login
    • Postcondicionaments
    • Veure panell de control corresponent en el que podrà veure els següents enllaços a un sidebar: «Informació de l’empresa» «Usuaris», «Clients», «Projectes», «Tipus de bosses d’hores», «Bosses d’hores». Al centre de la pagina podem veure un boto de «Nou projecte» , un altre amb «Nova bossa d’hores» i una llista amb les ultimes bosses d’hores sol·licitades que no estan validades, per poder així activar-les de manera fàcil i directa
    • Escenari principal o flux bàsic
    • 1. Fer login
    • 2. Veure el panell de control de administrador
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.3. Dades empresa

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «Dades empresa» al panell de control de l’administrador
    • Postcondicionaments
    • Veure la seccio «Dades empresa» en la que figuren totes les dades de l’empresa, i el nombre de «clients», «projectes», «bosses d’hores» i «tipus de bosses d’hores» que tenim, també un boto «editar» per editar les dades de l’empresa
    • Escenari principal o flux bàsic
    • 1. Fer login
    • 2. Veure panell de control corresponent en el que podrà veure els següents enllaços: «Usuaris», «Clients», «Projectes», «Tipus de bosses d’hores», «Bosses d’hores»
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.4. Usuaris

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «Usuaris» al panell de control de l’administrador
    • Postcondicionaments
    • Veure un llistat d’usuaris ordenats per data de creació de mes nou a mes antic 
    • Podrem veure 
        ◦ Nom d’usuari
        ◦ Nom
        ◦ Cognom/cognoms
        ◦ Correu electrònic
        ◦ Si son administradors o treballadors 
        ◦ Data de creació
        ◦ Botons «editar» i «eliminar» al costat. 
    • Un boto de «donar d’alta nou usuari». 
    • També un input per buscar per nom usuari, un altre per buscar per nom, un per cognom/cognoms, un per correu electrònic, un 1 select amb les opcions «Tots», «Administradors» i «Treballadors», «Tots» estarà marcat per defecte, un enllaç per buscar una alta en un interval de dates, quan cliquem s’obrira un div on podrem posar les 2 dates, quan cliquem a un dels 2 inputs ens sortira un calendari per escollir data, un select amb les opcions «Mes nous primer» i «Mes antics primer», «Mes nous» estarà per defecte amb un boto per filtrar amb les dades que haguem posat.
    • Escenari principal o flux bàsic
    • 1. Clicar a «Usuaris» al panell de control de l’administrador.
    • 2. Veure en pantalla la secció «Usuaris» 
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.5 Veure usuari amb les seves bosses d’hores i les seves entrades d’hores

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre el nom d’un usuari
    • Postcondicionaments
    • Es mostren totes les dades de l’usuari menys la seva contrasenya, i totes les dades de els les bosses d’hores que te assignades amb els botons «Editar» i «Eliminar» tant per l’usuari com per les seves bosses d’hores i «Validar/invalidar» per les bosses d’hores.
    • Escenari principal o flux bàsic
    • 1. Clicar sobre el nom d’un usuari
    • 2. Mostrar pagina amb l’informació
    • Extensions (o fluxes alternatius)
    • -----

2.3.6. Clients

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «Clients» al panell de control de l’administrador
    • Postcondicionaments
    • Veure un llistat de clients ordenats per data de creació de mes nou a mes antic
    • Podem veure
        ◦ Nom de l’empresa
        ◦ Correu electrònic
        ◦ Telèfon de contacte 
        ◦ Descripció limitada a 30 caràcters
        ◦ Data de creació. 
        ◦ Botons de «editar», «eliminar»
    • Un boto de «donar d’alta nou client». 
    • També un input per buscar clients per el nom de l’empresa, un altre per buscar per correu electrònic i un altre per buscar per telèfon, un select amb les opcions «Mes nous primer» i «Mes antics primer», «Mes nous» estarà per defecte amb un boto per filtrar amb les dades que haguem posat.
    • Escenari principal o flux bàsic
    • 1. Clicar a «Clients» al panell de control de l’administrador.
    • 2. Veure en pantalla la secció «Clients» 
    • Extensions (o fluxes alternatius)
    • ----- 


2.3.7. Veure client i els seus projectes

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre el nom d’un client
    • Postcondicionaments
    • Es mostren totes les dades del client, i les dades dels projectes que te assignats, i els botons «Editar» i «Eliminar» tant per el client com per els seus projectes
    • Escenari principal o flux bàsic
    • 1. Clicar sobre el nom d’un client
    • 2. Mostrar pagina amb l'informació
    • Extensions (o fluxes alternatius)
    • -----


2.3.8. Projectes

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «Projectes» al panell de control de l’administrador
    • Postcondicionaments
    • Veure un llistat de projectes ordenat per data de creació de mes nou a mes antic 
    • Podem veure
        ◦ Nom del projecte
        ◦ El nom del client
        ◦ Si el projecte està actiu o inactiu
        ◦ Una descripció limitada a 30 caràcters
        ◦ La data de la seva creació. 
        ◦ Botons «editar» i «eliminar» 
    • Un boto de «donar d’alta nou projecte». 
    • També 2 inputs per buscar per nom de projecte o buscar un projecte per nom de client, 1 select amb les opcions «Actiu» o «Inactiu», «Actiu» estarà per defecte, un select amb les opcions «Mes nous primer» i «Mes antics primer», «Mes nous» estarà per defecte amb un boto per filtrar amb les dades que haguem posat. 
    • Escenari principal o flux bàsic
    • 1. Clicar a «Projectes» al panell de control de l’administrador.
    • 2. Veure en pantalla la secció «Projectes» 
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.9. Veure projecte i les seves bosses d’hores

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre el nom d’un projecte
    • Postcondicionaments
    • Es mostren totes les dades del projecte i les dades de les bosses d’hores que te contractades, i els botons «Editar» i «Eliminar» tant per el projecte com per les seves bosses d’hores i «Validar/invalidar» per les bosses d’hores
    • Escenari principal o flux bàsic
    • 1. Clicar sobre el nom d’un projecte
    • 2. Mostrar pagina amb l'informació
    • Extensions (o fluxes alternatius)
    • ----- 
      
2.3.10. Tipus de bosses d’hores

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «Tipus de bosses d’hores» al panell de control de l’administrador
    • Postcondicionaments
    • Veure un llistat de tipus de bosses d’hores ordenades de mes antigues a mes noves
    • Podem veure
        ◦ El nom del tipus de la bossa d’hora
        ◦ El seu preu per hora
        ◦ La descripció limitada a 30 caràcters
        ◦ La seva data de creació. 
        ◦ Botons «editar» i «eliminar» 
    • Un boto «donar d’alta nou tipus de bossa d’hores». 
    • També 1 input per buscar un tipus de bossa d’hores per el seu nom, 1 input per buscar per el preu per hora, un select amb les opcions «Mes nous primer» i «Mes antics primer», «Mes antics» estarà per defecte amb un boto per filtrar amb les dades que haguem posat.
    • Escenari principal o flux bàsic
    • 1. Clicar a «Tipus de bosses d’hores» al panell de control de l’administrador.
    • 2. Veure en pantalla la secció «Tipus de bosses d’hores» 
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.11. Veure tipus de bossa d’hores

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre el nom d’un tipus de bossa d’hores
    • Postcondicionaments
    • Es mostren totes les dades del tipus de bossa d’hores, i els botons «Editar» i «Eliminar»
    • Escenari principal o flux bàsic
    • 1. Clicar sobre el nom d’un projecte
    • 2. Mostrar pagina amb l'informació
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.12. Bosses d’hores

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «Bosses d’hores» al panell de control de l’administrador
    • Postcondicionaments
    • Veure un llistat de bosses d’hores contractades ordenat per ordre d’alta de mes nou a mes antic.
    • Podrem veure 
        ◦ El nom del tipus de bossa d’hores
        ◦ El nom del projecte al que pertanyen
        ◦ Les hores contractades
        ◦ Les hores que te disponibles
        ◦ L’usuari que les ha contractat
        ◦ Si estan validades o invalidades
        ◦ La seva data de creació
        ◦ Botons «editar», «eliminar» i «validar/invalidar»
    • Boto «donar d’alta nova bossa d’hores»
    • També 1 input per buscar una bossa d’hores per el nom del tipus de bossa d’hores, 1 input per buscar per el nom del projecte, 1 input per buscar per hores contractades, 1 input per buscar per usuari que les ha contractat, un select per si estan actives o inactives, i un select amb les opcions «Mes nous primer» i «Mes antics primer», «Mes nous» estarà per defecte amb un boto per filtrar amb les dades que haguem posat. 
    • Escenari principal o flux bàsic
    • 1. Clicar a «Bosses d’hores» al panell de control de l’administrador.
    • 2. Veure en pantalla la secció «Bosses d’hores»
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.13. Alta

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «alta» d’algun ítem
    • Haver omplert tots els camps del ítem correctament i enviar el formulari
    • Postcondicionaments
    • El tipus d'ítem s’agrega correctament a la base de dades
    • Escenari principal o flux bàsic
    • 1. Clicar a «donar d’alta» un usuari, un client, un projecte, un tipus de bossa d’hores o una bossa d'hores
    • 2. S’obre un modal amb un formulari
    • 3. Omplir amb les dades del tipus d’input
    • 4. Enviar formulari 
    • 5. Mostrar missatge de confirmació de la creació del nou ítem al modal
    • Extensions (o fluxes alternatius)
    • Si no omplim tots els camps correctament no es donara d’alta a la BD i s’informara per pantalla al modal

2.3.14. Edició

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «editar» algun ítem
    • Tenir omplerts tots els camps del ítem correctament i enviar el formular
    • Postcondicionaments
    • El tipus d’item es modificat correctament a la base de dades
    • Escenari principal o flux bàsic
    • 1. Clicar a «editar» un usuari, un client, un projecte, un tipus de bossa d’hores o una bossa d'hores
    • 2. S’obre un modal amb un formulari omplert amb totes les dades de l'ítem que volem editar
    • 3. Canviem les dades que vulguem 
    • 4. Enviar formulari 
    • 5. Mostrar missatge de confirmació de la modificació del ítem al modal
    • Extensions (o fluxes alternatius)
    • Si no tenim omplerts tots els camps correctament no es donara d’alta a la BD i s’informara per pantalla al modal

2.3.15. Eliminació

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «eliminar» algun ítem
    • Postcondicionaments
    • El tipus d'ítem es eliminat correctament de la base de dades
    • Escenari principal o flux bàsic
    • 1. Clicar a «eliminar» algun ítem
    • 2. Mostrar modal amb missatge per preguntar si està segur que vol eliminar aquell ítem
    • 3. Confirmar que es vol eliminar
    • 4. Mostrar al modal missatge de confirmació de l’eliminació
    • Extensions (o fluxes alternatius)
    • Si es cancel·la al missatge de confirmació es tancara el badge i quedara sense eliminar de la base de dades

2.3.16. Validar i invalidar

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver clicat sobre «validar» o «invalidar» alguna bossa d’hores
    • Postcondicionaments
    • La bossa d’hores es validada o invalidada a la base de dades
    • Escenari principal o flux bàsic
    • 1. Clicar a «validar» o «invalidar» alguna bossa d’hores
    • 2. Mostrar modal amb missatge per preguntar si està segur que vol validar aquella bossa d’hores
    • 3. Confirmar que es vol validar o invalidar
    • 4. Mostrar al modal missatge de confirmació de la validació o invalidació
    • Extensions (o fluxes alternatius)
    • Si es cancel·la al missatge de confirmació es tancara el badge i quedara sense validar o invalidar a la base de dades

2.3.17. Rebre avis quan s’esgoti una bossa d’hores

    • Actor principal: Administrador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Que s’hagui esgotat una bossa d’hores
    • Postcondicionaments
    • Al correu electrònic del administrador rebrem un missatge que ens informarà de que s’ha esgotat una bossa d’hores, ens informara també de si tenim bosses d’hores del mateix projecte per validar
    • Escenari principal o flux bàsic
    • 1. Que s’esgoti una bossa d’hores d’un projecte
    • 2. Rebre el correu electrònic 
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.18. Panell de control del treballador

    • Actor principal: Treballador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Haver fet login
    • Postcondicionaments
    • Veure el panell de control corresponent al treballador.
    • Veurem les dades de l’empresa, es a dir, el seu nom, el seu logo , descripció, correu electrònic, telèfon i web, els seus nombres no.
    • També tindrem una llista amb les bosses d’hores que hem contractat
    • Podrem veure 
        ◦ El nom del tipus de bossa d’hores
        ◦ El nom del projecte al que pertanyen
        ◦ Les hores contractades
        ◦ Les hores que te disponibles
        ◦ Si estan validades o invalidades
        ◦ La seva data de creació
    • Escenari principal o flux bàsic
    • 1. Fer login
    • 2. Veure panell de control
    • Extensions (o fluxes alternatius)
    • ----- 

2.3.19. Contractar bosses d’hores

    • Actor principal: Treballador
    • Actor secundari: -----
    • Personal involucrat i interessos:-----
    • Precondicionaments
    • Clicar a «contractar bossa d’hores» al panell de control del treballador
    • Postcondicionaments
    • Contractar bossa d’hores amb èxit
    • Escenari principal o flux bàsic
    • 1. Veure pagina de contractar bossa d’hores
    • 2. Seleccionar projecte d’un select, tipus de bossa d’hores amb el seu preu també d’un select i nombre d’hores que es vol contractar
    • 3. Enviar formulari
    • 4. Veure missatge de confirmació informant també que un administrador ha de validar les hores
    • Extensions (o fluxes alternatius)
    • Si no omplim tots els camps s’informara per pantalla
    • Haurem d’esperar a que un administrador validi les hores

### 3. Diagrama de classes
![Diagrama de classes](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/class_diagram/diagrama_classes_praqutiques3.jpg)

### 4. Mockups del projecte [link a mockups](https://balsamiq.cloud/sudexx1/pnrc5zt)
**Anotació:** els forms per CRUD no els he fet per que es simplement demanar les dades necessàries de diferents maneres.

![Validar usuari](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Validar%20usuari.png)

![Panell de control de l'administrador](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Panell%20de%20control%20de%20l'administrador.png)

![Informacio de l'empresa](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Informacio%20de%20l'empresa.png)

![Usuaris](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Usuaris.png)

![Veure usuari, els seus projectes i les seves entrades](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Veure%20usuari%2C%20els%20seus%20projectes%20i%20les%20seves%20entrades.png)

![Clients](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Clients.png)

![Veure client Industries Lopez, els seus projectes, les seves bosses d'hores i les seves entrades d'hores](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Veure%20client%20Industries%20Lopez%2C%20els%20seus%20projectes%2C%20les%20seves%20bosses%20d'hores%20i%20les%20seves%20entrades%20d'hores.png)

![Projectes](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Projectes.png)

![Veure projecte, els seus usuaris, les seves bosses d'hores i les seves entrades](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Veure%20projecte%2C%20els%20seus%20usuaris%2C%20les%20seves%20bosses%20d'hores%20i%20les%20seves%20entrades.png)

![Bosses d'hores](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Bosses%20d'hores.png)

![Veure bossa d'hores d'un projecte](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Veure%20entrades%20d'una%20bossa%20d'hores%20d'un%20projecte.png)

![Tipus bosses d'hores](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Tipus%20bosses%20d'hores.png)

![Entrada d'hores](https://raw.githubusercontent.com/yannickbf-prog/gestor_hores/master/imgs_documentation/mockups/Entrada%20d'hores%20.png)
