# WWW-Ohjelmointi harjoitus 3

Toisen harjoituksen jälkeen olimme tilanteessa, jossa meille oli muodostunut kaksi merkittävää ongelmaan. Olimme muodostaneet vahvan riippuvuuden SQL -tietokantaan ja meiltä puuttui täysin rakenne sovelluksen logiikasta.

## Vahva sidos SQL -tietokantaan

Ensimmäisen ongelman, vahvan riippuvuuden SQL -tietokantaan, voimme ratkaista joko kerroksittaisella arkkitehtuurilla Active Record -tyyliin, tai Repository Patternilla noudattaen tarkemmin SRP:tä. Koska jokseenkin kaikki ohjelmistokehykset miltei kielestä riippumatta toteuttavat Active Recordia, valitaan se toteutustavaksi.

Nyt kaikki tietomalliluokat saavat tiedon varastointikyvyn abstraktilta Model -luokalta. Jatkossa kun tarvitsemme uusia tietomalliluokkia, joiden tietojen haluamme tallentuvan johonkin tietovarastoon, meidän tarvitsee vain periä Model -luokka.

Jos haluaisimme luoda käyttäjäluokan, jonka tiedot voidaan varastoida, meidän tulisi vähäisimmillään kirjoittaa vain:

	class User extends Model {}

Tämän jälkeen kaikki metodit ovat suoraan käytettävissämme, esimerkiksi:

	User::all(); // Valmistelee ja ajaa kyselyn SELECT * FROM user;, palauttaa tulokset User -luokan instansseina

Samalla meillä on vain yksi yhteyspiste SQL -tietokantaan. Jos meille tulee eteen tarve vaihtaa tietovarantoa, riittää, että korvaamme yhden tiedoston. Lisäksi, koska abstrakti luokka on kuin interface, i.e. sopimus siitä, mitä toiminnallisuutta pitää toteuttaa, sillä erolla, että abstrakti luokka saa toteuttaa osan toiminnallisuudesta itse, voimme periaatteessa vaihtaa yhden tietomalliluokan keskustelemaan yhdenlaisen tietovarannon kanssa ja toisen toisenlaisen. Tosin tässä kohtaa yksi interface -kerros väliin olisi parempaa arkkitehtuuria.

## Kaikki suorittava logiikka sekaisin (ja rumat osoitteet)

Aiemmin kaikki suorituksen logiikka on ollut `index.php` -tiedostossa. Tämä aiheuttaa pian ongelmia, jos sovellukseen lisätään uutta toiminnallisuutta, joka ei liity aiempaan. Esimerkiksi nyt kaikki toiminnallisuus liittyy tehtäviin, mutta jos meillä olisi lisäksi käyttäjiä ja käyttäjiin liittyvää toiminnallisuutta, haluaisimme varmasti jaotella suorittavan logiikan omiin karsinoihinsa aihealueen mukaan.

Lisäksi osoitteemme ovat jokseenkin rumia. Esimerkiksi osoite `index.php?action=merkkaa&id=1` ei ole kovin hyvä osoite, sillä oikeastaan `action=merkkaa` on jonkin toiminnallisuuspisteen osoite ja `id` on parametri tälle toiminnallisuudelle. Olisi parempi, jos voisimme merkata RESTful määrittelyn mukaisesti `/merkkaa/1`, tai vähintäänkin `/merkkaa/?id=1`. Merkkaaminen on lopulta sovelluksen toiminnallisuutta, eikä varsin parametri toiminnallisuudelle. WWW-palvelinohjelman kannalta `/merkkaa/1` tarkoittaisi kuitenkin, että avataan hakemisto `/merkkaa` ja sen alta hakemisto `/1` ja palautettaisiin sieltä jokin index -tiedosto, tai hakemistolistaus. Tästä syystä meidän täytyy joko `.htaccess` -tiedostolla, tai NginX:n tapauksessa Virtual Server blockissa määrittää, että pyyntö uudelleenkirjoitetaan ohjelmien ymmärtämään muotoon `index.php/merkkaa`.

Nyt saamme siis parametrin `/merkkaa` ja meidän täytyy sopia sille jokin merkitys. Tämän voimme tehdä `app/routes.php` -tiedostossa. Näin meille muodostuu yksi paikka, josta näemme kaikki sovelluksen vastaanottamat toiminnallisuusosoitteet. Lisäksi tarvitsemme jonkin komponentin toteuttamaan reititys tämän saadun osoitteen perusteella. `core/Router.php` lukee reititystiedoston, katsoo, mikä oli pyyntö, joka `core/Request.php` -luokassa kaunistellaan säännönmukaiseksi, ja delegoi suorituksen pyydetyn kokonaisuuden toteuttavalle kontrollerille.

Näin toiminnallisuus on jaoteltu eri suorittaviin tiedostoihin.

Tässä on edelleen huomattavia ongelmia. Nyt kontrolleritiedosto on edelleen vain pätkä koodia. Haluamme sen olevan luokka, jolla on metodeja ja haluamme reitittimen ohjaamaan noihin luokan metodeihin pyyntöjen mukaisesti. Tämän lisäksi reititin sivuuttaa nyt kokonaan sen, että meillä on eri tyyppisiä kutsuja. GET, POST, PUT/PATCH, DELETE, ... Jos sivuutamme kutsun tyypin, altistamme koodin XSS -hyökkäyksille. Joudumme siis refaktoroimaan toteutusta edelleen, mutta edetään näin pienin askelein ja jatketaan ongelmiin törmäämistä.