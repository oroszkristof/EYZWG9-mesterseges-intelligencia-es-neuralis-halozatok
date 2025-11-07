import random


# Kezdeti értékek
suly = random.uniform(0, 1)
eltolas = random.uniform(0, 1)
tanulasi_rata = 0.01
iteraciok = 100

# Valódi (tanulási cél) egyenes
valodi_m = 2
valodi_b = 1

# Véletlenszerű adatok generálása 0 és 10 között (1-2 lépés)
adatok = []
for _ in range(20):
    x = random.uniform(0, 10)
    y = valodi_m * x + valodi_b
    adatok.append((x, y))

# Tanítási ciklus
for lepes in range(iteraciok):
    # 1. Véletlen adat kiválasztása
    x, y = random.choice(adatok)
    
    # 2. Neuron előrejelzése
    y_becsles = suly * x + eltolas
    
    # 3. Hiba kiszámítása
    hiba = (y_becsles - y) ** 2
    
    # 4. Grádiensek meghatározása
    dH_dsuly = 2 * (y_becsles - y) * x
    dH_deltolas = 2 * (y_becsles - y)
    
    # 5. Paraméterek frissítése
    suly -= tanulasi_rata * dH_dsuly
    eltolas -= tanulasi_rata * dH_deltolas
    
    # Kiírás 10 lépésenként
    if (lepes + 1) % 10 == 0:
        print("Iteráció:", lepes + 1,
              "Hiba:", round(hiba, 4),
              "Súly:", round(suly, 4),
              "Eltolás:", round(eltolas, 4))

# Eredmény
print("\nTanulás vége.")
print("Tanult paraméterek: Súly =", round(suly, 4), ", Eltolás =", round(eltolas, 4))
print("Valódi paraméterek: m =", valodi_m, ", b =", valodi_b)
