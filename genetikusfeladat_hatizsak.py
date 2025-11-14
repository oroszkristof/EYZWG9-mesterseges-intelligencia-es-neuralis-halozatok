import random

C = 500  
targyak = [
    {"m": 100, "v": 300},
    {"m": 50, "v": 150},
    {"m": 120, "v": 280},
    {"m": 200, "v": 500},
    {"m": 90, "v": 240}
]

populacio_meret = 40
generaciok = 60
mutacio_valoszinuseg = 0.05


# Fitnesz függvény amely a hátizsákban lévő tárgyak értékét adja össze.
def fitness(kromoszoma):
    ossztomeg = 0
    ossz_ertek = 0
    for i in range(len(kromoszoma)):
        if kromoszoma[i] == 1:
            ossztomeg += targyak[i]["m"]
            ossz_ertek += targyak[i]["v"]
    if ossztomeg > C:
        return 0
    return ossz_ertek


# Kezdeti populáció létrehozása 
def letrehoz_populacio():
    populacio = []
    for _ in range(populacio_meret):
        kromoszoma = []
        for _ in range(len(targyak)):
            gen = random.randint(0, 1)
            kromoszoma.append(gen)
        populacio.append(kromoszoma)
    return populacio


# Szelekció - Két véletlenül kiválasztott kromoszómát hasonlít össze
def valogatas(populacio):
    egy = random.choice(populacio)
    ketto = random.choice(populacio)
    return egy if fitness(egy) > fitness(ketto) else ketto


# Keresztezés - Új egyedek létrehozása.
def keresztez(szulo1, szulo2):
    pont = random.randint(1, len(szulo1) - 1)
    gyerek1 = szulo1[:pont] + szulo2[pont:]
    gyerek2 = szulo2[:pont] + szulo1[pont:]
    return gyerek1, gyerek2


# Mutáció - Úg generációk létrehozása.
def mutacio(kromoszoma):
    uj = []
    for gen in kromoszoma:
        if random.random() < mutacio_valoszinuseg:
            uj.append(1 - gen)
        else:
            uj.append(gen)
    return uj


# Genetikus algoritmus 
def genetikus_algoritmus():
    populacio = letrehoz_populacio()

    for generacio in range(generaciok):
        uj_populacio = []

        while len(uj_populacio) < populacio_meret:
            szulo1 = valogatas(populacio)
            szulo2 = valogatas(populacio)
            
            # Keresztezés
            gyerek1, gyerek2 = keresztez(szulo1, szulo2)
            
            # Mutáció
            gyerek1 = mutacio(gyerek1)
            gyerek2 = mutacio(gyerek2)

            # Új elem létrehozása
            uj_populacio.extend([gyerek1, gyerek2])

        # A populáció frissítése
        populacio = sorted(uj_populacio, key=fitness, reverse=True)[:populacio_meret]

        
        if generacio < 10 or generacio % 10 == 0:
            print(f"Generáció: {generacio}, Legjobb fitness: {fitness(populacio[0])}")

    return populacio[0]



legjobb = genetikus_algoritmus()

print("\nLegjobb megoldás kromoszómája:", legjobb)
print("Összérték:", fitness(legjobb))
ossztomeg = sum(targyak[i]["m"] for i in range(len(targyak)) if legjobb[i] == 1)
print("Össztömeg:", ossztomeg)
