# Ohjeita PHP-kehyksen käyttöön

Alla olevia ohjeita ei ole tarkoitus toteuttaa. Saatte tosin tehdä mitä haluatte ja koodin pitäisi olla kunnossa, joten sen puoleen ei ole ongelmaa. Jos lataatte koodin, tekemänne mahdolliset muutokset eivät myöskään näy repositoryn (eli Tiko-ht:n) koodissa, joten tästä ei tartte huolehtia. Osa koodista on jo toteutettu kehyksessä.

Kuvitellaan, että haluamme luoda sivun, jossa näytetään kaikki tietokannassa olevat käyttäjät. Kantaan on luotu taulu "user" kommennoilla:

	CREATE TABLE user (
		id integer PRIMARY KEY AUTO_INCREMENT,
		name text NOT NULL,
		email text NOT Null
	);

`AUTO_INCREMENT` automaattisesti numeroi sarakkeen 'id' (eli 0, 1, 2...). Kuvitellaan, että taulusta löytyy käyttäjiä. Tässä esimerkissä ei oteta kantaa salasanan käsittelyyn. 

## 1. Luodaan reitti osoitteeseen, jossa käyttäjät halutaan näyttää

Kuvitellaan, että haluamme näyttää käyttäjät osoitteessa sivusto.fi/users. Aloitamme aluksi lisäämällä tämän reitin app\routes.php tiedostoon.

	$router->get('/users', ... );

Routes.php on tiedosto, jonka Router-luokka lataa suorituksen aikana, ja lisää routes.php-tiedostosta löytyvät reiti taulukkoonsa. Router siis rekisteröi routes.php:ssa olevat reiti.

Router-luokka jakaa kaikki reitit POST- ja GET-taulukoihin metodien get() ja post() perustella (tässä tapauksessa se on get()).  Aina kun kirjoitamme osoitekenttää osoitteen, teemme GET-pyynnön. Jos haluamme lisätä sivustolle (tai kantaan) tietoa, teemme POST-pyynnön. Näiden lisäksi on vielä DELETE- ja PUT-pyynnöt (poisto ja päivitys).

Reitin jälkeen lisätään routes.php:hen vielä kontrolleri ja kontrollerin metodi, jotka pyyntöön vastaavat.

	$router->get('/users', 'UserController@index);

Router-luokka pilkkoo `UserController@indexin` osiin, luo uuden instanssin kontrollerista: `$controller = new UserController;`, ja kutsuu controllerin metodia `$controller->index`. Jos menemme nyt osoitteeseen /users, saamme virheilmoituksen, koska kontrolleria (eikä sen metodia) ole vielä olemassakaan. Luomme siis seuraavaksi nämä.

## 2. Luodaan kontrolleri ja sen metodi

Kansiosta app\controllers löydämme kehyksemme kontrollerit. Kehys noudattaa MVC- eli Models Views Controllers-mallia, jossa Model on tässä tapauksessa User-luokka, Controller on UserController ja View on näkytmä, jonka kontrolleri lataa. Voimme kuvitella kontrollerin olevan siis työnjohtaja, mutta ei tästä sen enempää.

Luomme edellä mainittuun kansioon UserController.php-tiedoston, ja kirjoitamme tiedoston sisään:

	<?php
	
	namespace App\App\Controllers;
	
	class UserController
	{
		public function index() 
		{
		
		}
	}

**HUOM!** `namespace App\App\Controller;` on tärkeä, koska muuten Router-luokka ei löydä kontrolleria. Router etsii kontrollerit nimiavaruuksien perusteella, eikä esim. kansiorakenteen.

Jos nyt kirjoitamme index()-metodiin koodia, kuten

	echo 'Hello World!';
	
tulisi meidän nähdä nyt /users sivulla yllä mainittu teksti. Echo-funktio siis tulostaa näytölle tekstiä.

Mutta pelkkä 'Hello World!' tuskin kelpaa, joten seuraavaksi lataamme oikean näkymän sivulle.

## 3. Ladataan näkymä

Poistetaan edellinen echo-lauseke, ja kirjotetaan sen tilalle

	return view('users');

View()-funktio on core\helpers.php-tiedostosta löytyvä funktio, joka yksinkertaisesti lataa sille parametrina annetun näkymän. Tässä tapauksessa view() palauttaa tiedoston `users.view.php`, josta 'users' tuli parametrina. Voimme myös antaa view()-funktiolle dataa, jota käytetään näkymässä, mutta tästä lisää myöhemmin.

Nyt voimme luoda tiedoston `users.view.php` kansioon app\resources ja lisätä siihen haluamamme HTML-koodin. Kirjoitetaan esimerkiksi

	<ul>
		<li> Käyttäjä tähän <\li>
	<\ul>

Nyt jos menemme /users sivulle, näemme listan, jossa lukee 'Käyttäjä tähän.' Seuraavaksi on vuorossa käyttäjien noutaminen tietokannasta, ja tätä varten tarvitsemme luokan, joka vastaa user-taulun yhtä riviä.

## 4. Luodaan user-taulun riviä vastaava luokka

Kehyksestä löytyy funktioita, jotka noutavat dataa kannasta, mutta haluamme asettaa tämän datan tässä tapauksessa luokkaan, jotta saamme taulukon, joka on täytetty luokan instasseilla. Haluamme siis User-olioilla täytetyn taulukon.

Luomme kansioon app\models User.php-tiedoston, ja kirjoitamme siihen

		<?php
		
		namespace App\App\Models;
		
		use App\Core\Database\Model;
		
		class User extends Model
		{
		
		}

`Namespace App\App\Models;` lisää luokkamme `App\App\Models` nimiseen nimiavaruuteen, ja `use App\Core\Database\Model;` kommmennolla saamme käyttöömme `App\Core\Database` nimiavaruudesta löytyvän Model-luoka. Luokkamme User perii tämän Model-luokan ja kaikki sen metodit ja attribuutit. Luokallamme on siis jo hirveästi toiminnallisuutta, vaikka siinä ei ole riviäkään koodia.

Model-luokasta löytyy paljon SQL-kyselyihin perustuvaa koodia, kuten all()-metodi, joka etsii kannasta tietoa ja palauttaa tiedon metodin kutsuvan luokan instasseina. Sen sijaan, että kirjoittaisimme jokaiselle luokalle SQL-kyselyihin perustuvia metodeja, voimme vain periä Model-luokan, joka toteuttaa nämä kaikki. Meidän ei siis tarvitse kopioida koodia. Model-luokka osaa myös tunnistaa, mikä luokka kutsuu sen metodeja (esim. User vai Task), ja tehdä kyselyt sen perusteella.

Lisäämme User-luokkaamme vain kaksi attribuuttia:

		public $name;
		public $email;

Attribuutit vastaavat user-taulun sarakkeita 'name' ja 'email.' Nyt luokkamme on valmis. Seuraavaksi luomme taulukon User-olioista.

## 5. User-taulukko

Palataan UserControlleriin. Kirjoitetaan suoraan `namespace App\App\Controllers;`-lauseen alapuolelle lause `use App\App\Models\User;` Saamme siis kontrollerin käyttöön juuri luomamme User-luokan. Lisätään index()-metodiin return-lauseen yläpuolelle hyvin yksinkertainen lause:

		$userArray = User::all();

User-luokka perii Model-luokalta staattisen metodin `all()`, joka hakee kannasta tietoa ja palauttaa tämän tiedon metodin kutsuneen luokan instasseina. Tässä tapauksessa metodia kutsui User-luokka, joten kannasta saatu tieto sijoitetaan siis User-olioihin. All()-metodi palauttaa taulukon näistä olioista. Olioita on yhtä paljon, kun taulussa user on rivejä.

Olemme melkein valmiit. Taulukko on enää saatava näkymämme tietoon, jotta sen sisältö voidaan tulostaa.

## 6. Taulukko näkymälle

Aiemmin mainittu view()-funktio mahdollistaa tiedon siirron näkymälle. Muokataan return-lausetta hieman:

		return view('users', compact('userArray'));

Compact()-funktio 'pakkaa' sille antamamme datan nätisti. Helpers.php puolestaan 'purkaa' tämän paketin extract()-metodilla, jolloin view()-funktiolla on käytössään `$userArray`. Koska view()-funktio palauttaa näkymän `require`-funktiolla (eli sama kuin kirjaimellisesti lisäisi require-lauseessa olevan tiedoston koodin metodin perään), on näkymällä myös käytössään $userArray. Jäljellä on enää tämän taulukon tulostaminen.

## 7. Taulukon tulostus

Palataan `users.view.php`-tiedostoon. Muokataan HTML-koodia hieman:

	<ul>
        	<?php foreach ($userArray as $user) : ?>
            		<li>
				<?php $user->name; ?>
			</li>
        	<?php endforeach; ?>
	</ul>

`<?php ?>`-tageilla voimme lisätä PHP-koodia HTML-koodin sisään. `Foreach()`-funtkio on hyvin samanlainen kuin for-looppi (eli for(int i=0; i < ..). Se siis käy jokaisen `$userArray`-taulukon alkion läpi, ja lisää sen `$user`-muuttujaan. `$user`-muuttuja on siis User-luokan instanssi, jonka attribuutteina olivat 'name' ja 'email.' Tässä tapauksessa tulostamme jokaisen käyttäjän nimen lauseella `<?php $user->name; ?>`. `<?php endforeach; ?>` lopettaa loopin.

Näin saimme tulostettua kaikki käyttäjät. Prosessi saattaa vaikuttaa monimutkaiselta (ja tämä ohje on liian pitkä), mutta on helppo ymmärtää ja toteuttaa (toivottavasti).

# Ohjeita ympäristön asennukseen

Tarvitsemme muutaman ohjelman päästäksemme koodaileen:

	1. Wamp
	2. Composer
	3. Git
	
## 1. Wamp

Wamp on webbisovellusten tekoon suunniteltu kehitysympäristö, jonka mukana tulee mm. PHP ja MySQL-kanta. Wampin saa ladattua omalle koneelleen osoitteesta http://www.wampserver.com/en/, ja sen asennus on hyvin suoraviivaista. Tässä ohjeessa oletan, että asennatte Wampin sen oletuskansioon C:\wamp.

Kun asennuksen jälkeen käynnistätte Wampin, käynnistyy konelleenne oma palvelin, johon pääsette käsiksi osoitteesta localhost. Localhost lataa tiedostot kansiosta C:\wamp\www ja näyttää ne selaimessa. Tällä hetkellä sivulla pitäisi näkyä tietoa Wampista. Lisätään www-kansioon uusi kansio nimeltä tiko-ht (nimellä ei ole väliä). Tänne kansioon laitamme siis projektimme koodin ja näemme, miltä projektimme näyttää menemällä osoitteeseen localhost/tiko-ht.

Meillä on kuitenkin ongelma: jos klikkaamme projektissamme linkkiä, joka vie esim. osoitteeseen `/users`, ohjautuu pyyntömme osoitteeseen localhost/users. Oikean näkymän saamme aikaiseksi, jos lisäämme linkin `/users` etuliitteen `tiko-ht/`, eli linkki olisi tällöin `tiko-ht/users`. Tämä on kuitenkin huono ratkaisu, koska joutuisimme lisäämään etuliitteen `tiko-ht/` **KAIKKIIN** sivustomme linkkeihin ja poistamaan ne, kun siirrämme koodin koulun palvelimelle. Haluamme siis, että localhost vie meidät suoraan `tiko-ht`-kansioon, eli asetamme serverin `localhost` juurikansioksi `C:\wamp\www\tiko-ht`.

[OHJEET TÄHÄN]

## 2. Composer

Composer on pakettienhallintatyökalu PHP:lle. Projektimme juuressa on lista PHP-kirjastoista tiedostossa `composer.json`, joista projektimme on riippuvainen. Saamme nämä kaikki kirjastot asennettua helposti vain navigoimalla projektimme juureen komentorivillä ja syöttämällä komennon `composer install`. Kirjastot asentuvat `vendor`-kansioon projektin juuressa. Kaikki tulevaisuudessa asentamamme kirjastot tulevat myös tähän listaan automaattisesti. Voimme siis vain jakaa tämän listan projektin kehittäjien kesken, jolloin jäsenet voivat helposti itse asentaa vaadittavat kirjastot sen sijaan, että jakaisimme itse kirjastot. Composer pitää myös huolen, että kirjastot ovat ajan tasalla. Composer toimii lähes identtisesti Node Package Managerin (NPM:n) kanssa, joka keskittyy javascript-kirjastoihin.

Composerin asennus on erittäin helppoa: lataatte osoitteesta https://getcomposer.org/download/ `Composer-Setup.exe`-tiedoston ja asennatte sen. Asennuksen yhteydessä Composer pyytää `php.exe`-tiedoston sijaintia, joka löytyy `C:\wamp\bin\php\php7.x.x\php.exe`. Nyt composer on asennettu, ja sitä käytetään komentorivillä komennoilla `composer <komento>`.

## 3. Git

Git on versionhallintatyökalu, ja sitä käytetään varmaan kaikissa maailman koodausprojekteissa. Gitin saa ladattua ja asennettua osoitteesta http://git-scm.com/download/win. Composerin tavoin Gittiä käytetään komentorivillä.

Tämän jälkeen teette käyttäjät (ellei ole jo) github.comiin. Tämän jälkeen teidän tulee liittää tietokoneillanne generoimat `SSH-avaimet` käyttäjiinne. Generoinnin helpot ohjeet löytyvät osoitteesta [OSOITE TÄHÄN] ja avaimen linkitys käyttäjään osoitteesta [OSOITE TÄHÄN]. `SSH-avain` linkittää tietokonneenne Github-käyttäjiinne. Tämä tarkoittaa sitä, että jos annan käyttäjillenne kaikki oikeudet Tiko-ht-repositorioon, myös käyttäjiinne linkitetyillä tietokoneilla on nämä oikeudet. Voitte siis tehdä repositorioon muutoksia komentorivillänne git-komennoilla ilman, että kirjaudutte Github-käyttäjällänne sisään jonkin ohjelman kautta.

Hyvin yksinkertainen git-komento on `git clone git@github.com:JaakkoUta/Tiko-ht.git`, joka kloonaa Tiko-ht-repositorion koneellenne. Tämä ei ole kuitenkaan sama kuin vain lataisi repon koneelle, vaan kloonauksen mukana tulee myös git-komennoilla tehtyjen muutosten historia. Eli vaikka tulisitte kesken kaiken projektiin mukaan ja kloonnaatte projektin repon koneellenne, näette esim. `SourceTree`-ohjelmalla kaikki muutokset, mitä projektiin ollaan tehty aivan sen alkuajoista lähtien.

Nyt voitte komentorivillä navigoida kansioon `C:\wamp\www` ja syöttää komennon `git clone git@github.com:JaakkoUta/Tiko-ht.git Tiko-ht`. Komennon lopussa oleva `Tiko-ht` määrittelee kansion, mihin repo kloonataan. Näin käytössänne on kloonattu repositorio osoitteessa `localhost`, johon voitte gitin avulla ryhtyä koodaamaan.
