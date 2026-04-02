
db = db.getSiblingDB('vite_et_gourmand_stats');

db.avis.insertMany([
    {
        id: 1,
        utilisateur_id: 5,
        commande_id: 1,
        note: 5,
        commentaire: "Bon rapport qualité prix.",
        valide: 1,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-10T14:00:00Z")
    },
    {
        id: 2,
        utilisateur_id: 6,
        commande_id: 3,
        note: 4,
        commentaire: "Excellent menu vegan !",
        valide: 1,
        menu_libelle: "Menu Vegan",
        created_at: new Date("2026-02-11T20:00:00Z")
    },
    {
        id: 3,
        utilisateur_id: 7,
        commande_id: 2,
        note: 5,
        commentaire: "Parfait pour les enfants.",
        valide: null,
        menu_libelle: "Menu Junior",
        created_at: new Date("2026-02-12T21:00:00Z")
    },
    {
        id: 4,
        utilisateur_id: 8,
        commande_id: 4,
        note: 3,
        commentaire: "Correct mais peut mieux faire.",
        valide: 1,
        menu_libelle: "Menu Végétarien",
        created_at: new Date("2026-02-13T22:00:00Z")
    },
    {
        id: 5,
        utilisateur_id: 10,
        commande_id: 6,
        note: 4,
        commentaire: "Correct mais peut mieux faire.",
        valide: 2,
        menu_libelle: "Menu Végétarien",
        created_at: new Date("2026-02-13T22:00:00Z")
    },
    {
        id: 6,
        utilisateur_id: 11,
        commande_id: 7,
        note: 3,
        commentaire: "Correct mais peut mieux faire.",
        valide: 1,
        menu_libelle: "Menu Végétarien",
        created_at: new Date("2026-02-13T22:00:00Z")
    },
    {
        id: 7,
        utilisateur_id: 12,
        commande_id: 8,
        note: 1,
        commentaire: "Une arnaque !!!.",
        valide: 2,
        menu_libelle: "Menu Végétarien",
        created_at: new Date("2026-02-13T22:00:00Z")
    },
    {
        id: 8,
        utilisateur_id: 9,
        commande_id: 5,
        note: 4,
        commentaire: "Très bon service.",
        valide: null,
        menu_libelle: "Menu Classique",
        created_at: new Date("2026-02-14T15:00:00Z")
    }
])
