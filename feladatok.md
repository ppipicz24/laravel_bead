Modellek és seeder (4 pont) [x]

    Minden modellből kerüljön tárolásra észszerű mennyiségben (pl. 10-15 csapat), valamint a köztük lévő kapcsolatokból is generálj! [x]

    A seeder fedjen le minél több esetet, tehát legyenek pl. már lejátszott, folyamatban lévő és jövőbeli meccsek is, valamint változatos események az egyes meccseken belül! [x]

    Minden szükséges seedelés egyetlen parancs kiadására történjen meg: php artisan db:seed vagy php artisan migrate:fresh --seed [x]

    Az egyszerű felhasználók csak userX@szerveroldali.hu (ahol X eleme természetes számok) e-mail címmel és password jelszóval jöjjenek létre az egyszerűség kedvéért! [x]

    Egyetlen admin jogosultságú felhasználó legyen, akinek a bejelentkezési adatai fixen: admin@szerveroldali.hu - adminpwd [x]

Főoldal (1 pont) []

    Az alkalmazás gyökér útvonalán jelenjen meg egy statikus oldal, amelyen tájékoztatást kapunk arról, hogy milyen webhelyre érkeztünk, és a következő menüpontok közül választhatunk:
        mérkőzések [x]
        csapatok [x]
        tabella [x]
        kedvenceim []

Mérkőzések oldal (4 pont) []

    Ezt az oldalt bárki (vendég, bejelentkezett, admin) megtekintheti. [x]
    
    Az oldalon megjelenik az összes mérkőzés: a mérkőzésben részt vevő két csapat neve (vagy rövidítése), logója (ha van feltöltve, különben placeholder kép) és a meccs kezdési időpontja. [x]
    
    A mérkőzések alapvetően időrendi sorrendben jelennek meg, de külön szekcióba ki kell emelni az éppen folyamatban lévő meccseket (amelyek kezdési időpontja elmúlt, de nincsenek még befejezettként jelölve). [x]

    A folyamatban lévő és befejezett mérkőzéseknél az aktuális eredmény is legyen látható! Ezt az adott meccshez tartozó gól és öngól típusú események alapján kell valós időben kiszámolni, tehát nem szabad külön fix adatként eltárolni az eredményt! (Figyelem: az öngólt értelemszerűen az ellenfél javára kell számolni, nem pedig a gólszerző játékos csapatának!) []
    
    Lapozással biztosítsd, hogy csak bizonyos (pl. 10, 15, 20, stb.) számú mérkőzés jelenjen meg egyidejűleg az oldalon, utána lapozni kelljen! Ez alól kivételt képezhet a folyamatban lévő meccsek szekciója, amelyekről feltételezhetjük, hogy egyszerre viszonylag kevés van, és akár minden 
    lapozott oldal tetején is szerepelhet. [x]
    
    Egy adott mérkőzésre kattintva annak részletező oldalára jutunk. [x]

Mérkőzésrészletező oldal (2 pont) []

    Ezen az oldalon is láthatók a paraméterként kapott meccs alapvető adatai, illetve folyamatban lévő vagy befejezett mérkőzés esetén az eredmény is. [x]

    Időrendi sorrendben megjelenik az adott meccshez tartozó összes esemény. (pl. "7. perc, Unikornis FC, gól, Programo Zoltán") [x]-a seeder miatt rossz értékeket ir ki

Új esemény rögzítése (3 pont) []

    Az admin felhasználó számára a mérkőzésrészletező oldalról (pl. az alján elhelyezett űrlapon vagy innen elérhető külön oldalon) lehetőség van új esemény rögzítésére egy folyamatban lévő mérkőzéshez. []

    Ehhez meg kell adnia a következőket: hányadik játékpercben (1 és 90 közötti egész), milyen típusú esemény (gól, öngól, sárga lap, piros lap) történt és ki az érintett játékos. Alapvetően nem szükséges külön kiválasztani (vagy tárolni) a csapatot, hiszen azt a játékos személye egyértelműen meghatározza. []

    Az érintett játékost egy listából (pl. legördülő menü vagy rádiógombok) lehet kiválasztani, amely csapat és mezszám szerint rendezett. []

Esemény visszavonása (1 pont) []

    Az admin felhasználó az egyes eseményeket vissza is vonhatja (törölheti), pl. téves rögzítés esetén. []

    Visszavonni csak addig lehet eseményeket, amíg a meccs folyamatban van. Lezárt mérkőzés eseményeihez nem lehet hozzányúlni.[]

Meccs lezárása (1 pont) [X]

    Az admin felhasználó számára a mérkőzésrészletező oldalról lehetőség van a meccs lezárására, tehát befejezetté nyilvánítására.[]

    A lezárt meccshez további esemény nem rögzíthető, illetve a meccs ezután nem jelenik meg a folyamatban lévő mérkőzések szekciójában.[]

Új mérkőzés létrehozása (3 pont)[x]
    
    Az admin felhasználó új mérkőzéseket is kiírhat.[x]

    Az egyes mezőkre jellemző alapvető validációs feltételek mellett ellenőrizni kell, hogy a kezdés időpontja jövőbeli, illetve a hazai és vendég csapat nem azonos.[x]

Meglévő mérkőzés módosítása (3 pont)[x]

    Az admin felhasználó módosíthatja is a meglévő mérkőzéseket.[X]

Mérkőzés törlése (1 pont) [x]

    Az admin felhasználó törölheti is a meglévő mérkőzéseket, amennyiben még nincs esemény rögzítve az adott meccshez![]

Csapatok listája (2 pont)[x]

    Ezt az oldalt bárki (vendég, bejelentkezett, admin) megtekintheti.[x]

    Az oldalon megjelenik az összes csapat neve, rövidítése és logója (ha van feltöltve, különben placeholder kép). [x]

    A lista a csapatok neve szerint betűrendbe rendezve jelenik meg.[x]

    Az egyes csapatokra kattintva továbblépünk az adott csapat részletező oldalára.[x]

Csapatrészletező oldal (2 pont)[x]

    A csapatrészletező oldalon két fontos információ kell megjelenjen:
        -A csapat mérkőzései időrendi sorrendben.(Természetesen itt is fel kell tüntetni az eredményt a folyamatban lévő és befejezett meccsek esetében.)[x]
        -A csapatban lévő összes játékos adatai: neve, születési dátuma, statisztikái (hány gólt, öngólt rúgott, illetve hány sárga és piros lapot kapott).[x]

Új csapat hozzáadása (4 pont)[x]

    Az admin tudjon új csapatot felvenni a bajnokságba. Ehhez meg kell adjon minden kötelező adatot, de logó feltöltése opcionális![x]

    A logóhoz tartozó képfeltöltés ténylegesen legyen fájlfeltöltés, tehát nem elég csupán a kép nevét vagy egy külső URL-t eltárolni![x]

Meglévő csapat módosítása (4 pont)[]

    Az admin a csapat részletező oldaláról átlépve tudja módosítani is a felvett csapatok adatait és/vagy logóját.[x]

    Ha már van feltöltött kép, és nem tölt fel fájlt, akkor maradjon meg az előző kép; különben értelemszerűen le kell cserélni.[x]

Új játékos felvétele (2 pont)[x]

    Az admin tudjon új játékost felvenni a csapatba annak részletező oldaláról indulva. Ehhez meg kell adjon minden kötelező adatot, tehát a játékos mezszámát, nevét és születési dátumát.[]
    
Meglévő játékos törlése (1 pont)[x]
    
    Az admin tudjon törölni olyan játékosokat, akikhez nem tartozik még esemény egy meccsen sem. Tehát azokat a játékosokat, akik letettek már valamit az asztalra, nem töröljük a jegyzőkönyvekből![]

Tabella oldal (4 pont)[]

    A tabella oldalon megjelenik a bajnokságban résztvevő összes csapat az elért pontszámuk szerinti sorrendben.[]

    Egy csapat pontszámát a befejezett mérkőzései alapján kell számítani a következő módon: [x]
        nyert mérkőzés: +3 pont
        döntetlen: +1 pont
        vesztes mérkőzés: +0 pont

    Ha két csapat pontszáma a fentiek szerint azonos, akkor az kerüljön a sorrendben előrébb, akinek jobb a gólkülönbsége (szerzett gólokból kivonjuk a kapott gólok számát). Ha még mindig egyenlőség van, akkor a betűrendben előbb lévő csapat kerüljön feljebb a rangsorban.[]

Kedvenceim oldal (4 pont)[]

    Ez az oldal csak bejelentkezett felhasználók számára elérhető.[x]

    A nem bejelentkezett felhasználóknak ajánljuk fel a bejelentkezés vagy regisztráció lehetőségét, amely természetesen működjön is megfelelően![x]

    A bejelentkezett felhasználók minden olyan helyen, ahol csapatnév vagy rövidítés szerepel (pl. meccsek, csapatok, tabella) kedvencnek tudják jelölni a csapatukat egy gombra vagy ikonra kattintva.[]
    
    A már kedvencnek jelölt csapat ugyanígy el is távolítható a kedvencek közül.[]
    
    A kedvenceim oldalon a bejelentkezett felhasználók csak azokat a mérkőzéseket látják, amelyben valamelyik kedvencnek jelölt csapatuk részt vesz.[]

Védésre szerezhető pontszám (4 pont)[]
    
    További 4 pont szerezhető a védés során mutatott általános jártasságra a témában.

    Nem várjuk el senkitől, hogy másfél-két hónap alatt mesterévé váljon a Laravel lelki világának; viszont azt igen, hogy a saját projektjét alapvetően tudja navigálni és a gyakorlaton lefedett ismeretekkel kapcsolatos kiegészítő kérdésekre tudjon értékelhetően válaszolni. Normál esetben a védés 15-20 percnél tovább nem tart.

    Amennyiben a hallgató a szóbeli védés során teljes tájékozatlanságot mutat, az egész beadandó feladat visszautasítható!