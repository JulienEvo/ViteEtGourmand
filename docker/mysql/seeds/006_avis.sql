/*** AVIS ***/
INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
           3,
           1,
           5,
           'Nous avons commandé un buffet pour notre anniversaire et tout était délicieux ! Service impeccable et produits frais. Je recommande vivement.',
           1,
           CURRENT_DATE
       );

INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
           4,
           3,
           4,
           'Traiteur très professionnel. Les plats étaient délicieux et présentés avec soin. Nos invités ont adoré !',
           1,
           CURRENT_DATE
       );

INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
           3,
           2,
           5,
           'Une équipe très réactive et sympathique. Les plats faits maison étaient excellents et le buffet parfaitement organisé.',
           1,
           CURRENT_DATE
       );

INSERT INTO avis (utilisateur_id, commande_id, note, commentaire, valide, created_at)
VALUES (
           4,
           4,
           3,
           'Parfait, je recommande',
           null,
           CURRENT_DATE
       );

