
db = db.getSiblingDB('vite_et_gourmand_stats');

db.commande.insertMany([
    {
        commande_id: 1,
        commande_numero: "C26020001",
        utilisateur_id: 6,
        menu_id: 1,
        quantite: 2,
        total_menu: 30,
        total_ttc: 60,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-10T12:00:00Z")
    },
    {
        commande_id: 2,
        commande_numero: "C26020002",
        utilisateur_id: 11,
        menu_id: 6,
        quantite: 2,
        total_menu: 30,
        total_ttc: 60,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-10T12:00:00Z")
    },
    {
        commande_id: 3,
        commande_numero: "C26020003",
        utilisateur_id: 5,
        menu_id: 6,
        quantite: 2,
        total_menu: 30,
        total_ttc: 60,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-10T12:00:00Z")
    },
    {
        commande_id: 4,
        commande_numero: "C26020004",
        utilisateur_id: 9,
        menu_id: 1,
        quantite: 2,
        total_menu: 30,
        total_ttc: 60,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-10T12:00:00Z")
    },
    {
        commande_id: 5,
        commande_numero: "C26020005",
        utilisateur_id: 10,
        menu_id: 4,
        quantite: 1,
        total_menu: 20,
        total_ttc: 20,
        menu_libelle: "Menu Vegan",
        created_at: new Date("2026-02-11T18:30:00Z")
    },
    {
        commande_id: 6,
        commande_numero: "C26020006",
        utilisateur_id: 7,
        menu_id: 8,
        quantite: 3,
        total_menu: 15,
        total_ttc: 45,
        menu_libelle: "Menu Junior",
        created_at: new Date("2026-02-12T19:00:00Z")
    },
    {
        commande_id: 7,
        commande_numero: "C26020007",
        utilisateur_id: 11,
        menu_id: 2,
        quantite: 5,
        total_menu: 15,
        total_ttc: 75,
        menu_libelle: "Menu Végétarien",
        created_at: new Date("2026-02-13T20:15:00Z")
    },
    {
        commande_id: 8,
        commande_numero: "C26020008",
        utilisateur_id: 12,
        menu_id: 4,
        quantite: 2,
        total_menu: 30,
        total_ttc: 60,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-14T13:00:00Z")
    },
    {
        commande_id: 9,
        commande_numero: "C26020009",
        utilisateur_id: 8,
        menu_id: 3,
        quantite: 2,
        total_menu: 30,
        total_ttc: 60,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-10T12:00:00Z")
    },
    {
        commande_id: 10,
        commande_numero: "C26020010",
        utilisateur_id: 5,
        menu_id: 9,
        quantite: 1,
        total_menu: 20,
        total_ttc: 20,
        menu_libelle: "Menu Vegan",
        created_at: new Date("2026-02-11T18:30:00Z")
    },
    {
        commande_id: 11,
        commande_numero: "C26020011",
        utilisateur_id: 11,
        menu_id: 10,
        quantite: 3,
        total_menu: 15,
        total_ttc: 45,
        menu_libelle: "Menu Junior",
        created_at: new Date("2026-02-12T19:00:00Z")
    },
    {
        commande_id: 12,
        commande_numero: "C26020012",
        utilisateur_id: 6,
        menu_id: 8,
        quantite: 5,
        total_menu: 15,
        total_ttc: 75,
        menu_libelle: "Menu Végétarien",
        created_at: new Date("2026-02-13T20:15:00Z")
    },
    {
        commande_id: 13,
        commande_numero: "C26020013",
        utilisateur_id: 7,
        menu_id: 7,
        quantite: 2,
        total_menu: 30,
        total_ttc: 60,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-14T13:00:00Z")
    }
])
