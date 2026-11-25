<?php
/**
 * Starter aliases, approved by the owner 2026-11-25 (VACCINE_ALIAS_SEED_REVIEW.md).
 * Loaded by the "Load starter aliases" button (Vaccines -> Search Misses & Test).
 * Rows: [ alias, kind, vaccine post ID, brand post ID or 0, public note ].
 * Re-running skips any (alias, vaccine) pair that already exists.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$hexa  = '6-in-1: DTaP + IPV + Hib + Hep B';
$penta = '5-in-1: DTwP + Hib + Hep B';

return [
    // 53 BCG
    [ 'BCG', 'abbreviation', 53, 0, 'Tuberculosis vaccine, given at birth' ],
    [ 'Tuberculosis', 'generic', 53, 0, '' ],
    [ 'TB vaccine', 'generic', 53, 0, '' ],

    // 237 Chicken Pox
    [ 'Varicella', 'generic', 237, 0, 'Chicken pox vaccine' ],
    [ 'Chickenpox', 'generic', 237, 0, '' ],
    [ 'VZV', 'abbreviation', 237, 0, '' ],
    [ 'Vaxapox', 'brand', 237, 180, '' ],
    [ 'Varicela', 'misspelling', 237, 0, '' ],

    // 296 Cholera
    [ 'OCV', 'abbreviation', 296, 0, 'Oral cholera vaccine' ],
    [ 'Euvichol', 'brand', 296, 273, '' ],
    [ 'Euvichol Plus', 'brand', 296, 273, '' ],
    [ 'Choelra', 'misspelling', 296, 0, '' ],

    // 117 DTaP+IPV+Hib+HB (Hexa)
    [ 'Hexaxim', 'brand', 117, 335, $hexa ],
    [ 'Infanrix Hexa', 'brand', 117, 142, $hexa ],
    [ 'Hexa', 'epi', 117, 0, $hexa ],
    [ 'Hexavalent', 'generic', 117, 0, $hexa ],
    [ '6 in 1', 'generic', 117, 0, '' ],
    [ 'DTaP', 'combination', 117, 0, 'Combination: contains DTaP + IPV + Hib + Hep B' ],
    [ 'DTP', 'combination', 117, 0, 'Combination: contains DTaP + IPV + Hib + Hep B' ],
    [ 'DPT', 'combination', 117, 0, 'Combination: contains DTaP + IPV + Hib + Hep B' ],
    [ 'IPV', 'combination', 117, 0, 'Combination: contains IPV (injected polio)' ],
    [ 'Hib', 'combination', 117, 0, 'Combination: contains Hib' ],
    [ 'Hep B', 'combination', 117, 0, 'Combination: contains Hep B' ],
    [ 'Hexaxin', 'misspelling', 117, 0, '' ],

    // 115 DTwP+Hib+HB (Penta)
    [ 'Penta', 'epi', 115, 0, $penta . ' (EPI)' ],
    [ 'Pentavalent', 'generic', 115, 0, $penta ],
    [ '5 in 1', 'generic', 115, 0, '' ],
    [ 'DTwP', 'combination', 115, 0, 'Combination: contains DTwP + Hib + Hep B' ],
    [ 'DTP', 'combination', 115, 0, 'Combination: contains DTwP + Hib + Hep B' ],
    [ 'DPT', 'combination', 115, 0, 'Combination: contains DTwP + Hib + Hep B' ],
    [ 'Hib', 'combination', 115, 0, 'Combination: contains Hib' ],
    [ 'Hep B', 'combination', 115, 0, 'Combination: contains Hep B' ],

    // 123 Hepatitis A
    [ 'Hep A', 'abbreviation', 123, 0, '' ],
    [ 'HAV', 'abbreviation', 123, 0, '' ],
    [ 'Havrix', 'brand', 123, 177, '' ],
    [ 'Havrix 720', 'brand', 123, 177, 'Child dose' ],
    [ 'Havrix 1440', 'brand', 123, 301, 'Adult dose' ],
    [ 'Havrix junior', 'brand', 123, 177, '' ],

    // 54 Hepatitis B
    [ 'Hep B', 'abbreviation', 54, 0, '' ],
    [ 'HBV', 'abbreviation', 54, 0, '' ],
    [ 'HB', 'epi', 54, 0, 'Hepatitis B (birth dose on EPI card)' ],
    [ 'Engerix', 'brand', 54, 153, '' ],
    [ 'Engerix B Paediatric', 'brand', 54, 153, '' ],
    [ 'Engerix B Adult', 'brand', 54, 343, '' ],
    [ 'Heplisav-B', 'brand', 54, 155, '' ],
    [ 'Helisav', 'misspelling', 54, 155, '' ],
    [ 'Amvax B', 'brand', 54, 0, '' ],

    // 300 HPV
    [ 'Human papillomavirus', 'generic', 300, 0, '' ],
    [ 'Cervical cancer vaccine', 'generic', 300, 0, '' ],
    [ 'Gardasil', 'brand', 300, 194, '' ],
    [ 'Gardasil 9', 'brand', 300, 194, '' ],
    [ 'Cervarix', 'brand', 300, 196, '' ],
    [ 'Cecolin', 'brand', 300, 0, '' ],

    // 120 Influenza
    [ 'Flu', 'generic', 120, 0, '' ],
    [ 'Influenza', 'generic', 120, 0, '' ],
    [ 'Flu shot', 'generic', 120, 0, '' ],
    [ 'Vaxigrip', 'brand', 120, 175, '' ],
    [ 'Vaxigrip Tetra', 'brand', 120, 175, '' ],
    [ 'Influvac', 'brand', 120, 176, '' ],
    [ 'Fluarix', 'brand', 120, 173, '' ],
    [ 'Anflu', 'brand', 120, 330, '' ],
    [ 'Influenza vaccine', 'generic', 120, 0, '' ],

    // 313 IPV
    [ 'IPV', 'abbreviation', 313, 0, 'Injected polio vaccine' ],
    [ 'fIPV', 'epi', 313, 0, 'Injected polio vaccine (fractional dose on EPI card)' ],
    [ 'Inactivated polio', 'generic', 313, 0, '' ],
    [ 'Polio injection', 'generic', 313, 0, '' ],
    [ 'Imovax', 'brand', 313, 192, '' ],
    [ 'Polio', 'generic', 313, 0, 'Injected polio vaccine' ],

    // 56 OPV
    [ 'OPV', 'abbreviation', 56, 0, 'Oral polio drops' ],
    [ 'bOPV', 'epi', 56, 0, 'Oral polio drops (EPI)' ],
    [ 'Polio drops', 'generic', 56, 0, '' ],
    [ 'Oral polio', 'generic', 56, 0, '' ],
    [ 'Polio', 'generic', 56, 0, 'Oral polio drops' ],

    // 339 Men B
    [ 'MenB', 'abbreviation', 339, 0, 'Meningococcal B' ],
    [ 'Meningococcal B', 'generic', 339, 0, '' ],
    [ 'Bexsero', 'brand', 339, 340, '' ],
    [ 'Bexero', 'misspelling', 339, 340, '' ],
    [ 'Meningococcal', 'generic', 339, 0, 'Meningococcal B' ],
    [ 'Meningitis vaccine', 'generic', 339, 0, 'Meningococcal B' ],

    // 121 Men-ACYW135
    [ 'MenACWY', 'abbreviation', 121, 0, 'Meningococcal A, C, W, Y' ],
    [ 'ACWY', 'abbreviation', 121, 0, '' ],
    [ 'MCV4', 'abbreviation', 121, 0, '' ],
    [ 'Menactra', 'brand', 121, 184, '' ],
    [ 'Nimenrix', 'brand', 121, 271, '' ],
    [ 'Menveo', 'brand', 121, 186, '' ],
    [ 'Meningococcal', 'generic', 121, 0, 'Meningococcal A, C, W, Y' ],
    [ 'Meningitis vaccine', 'generic', 121, 0, 'Meningococcal A, C, W, Y' ],

    // 238 MMR
    [ 'Measles', 'generic', 238, 0, '' ],
    [ 'Mumps', 'generic', 238, 0, '' ],
    [ 'Rubella', 'generic', 238, 0, '' ],
    [ 'M-M-R II', 'brand', 238, 147, '' ],
    [ 'MMR', 'brand', 238, 151, '' ],
    [ 'Priorix', 'brand', 238, 149, '' ],
    [ 'Trimovax', 'brand', 238, 0, '' ],
    [ 'MR', 'epi', 238, 0, "EPI's MR covers measles + rubella; MMR also covers mumps" ],

    // 58 Pneumococcal Vaccine (post 68 "PCV" is a duplicate; owner decision Q1)
    [ 'PCV13', 'abbreviation', 58, 159, 'Pneumococcal conjugate, 13 strains' ],
    [ 'PCV10', 'abbreviation', 58, 161, 'Pneumococcal conjugate, 10 strains' ],
    [ 'PCV20', 'abbreviation', 58, 163, 'Pneumococcal conjugate, 20 strains' ],
    [ 'Prevenar 13', 'brand', 58, 159, '' ],
    [ 'Prevenar 20', 'brand', 58, 163, '' ],
    [ 'Prevenar', 'brand', 58, 159, '' ],
    [ 'Prevnar', 'misspelling', 58, 159, '' ],
    [ 'Synflorix', 'brand', 58, 161, '' ],
    [ 'PCV', 'abbreviation', 58, 0, 'Pneumococcal conjugate vaccine' ],
    [ 'Pneumococcal', 'generic', 58, 0, '' ],
    [ 'Pneumonia vaccine', 'generic', 58, 0, '' ],

    // 67 Rabies
    [ 'ARV', 'abbreviation', 67, 0, 'Anti-rabies vaccine' ],
    [ 'Anti rabies', 'generic', 67, 0, '' ],
    [ 'Dog bite vaccine', 'generic', 67, 0, 'Rabies vaccine. After a bite, see a doctor the same day' ],
    [ 'Verorab', 'brand', 67, 0, '' ],
    [ 'Dowrab', 'brand', 67, 0, '' ],

    // 57 Rotavirus
    [ 'Rota', 'epi', 57, 0, 'Oral rotavirus drops' ],
    [ 'Rotarix', 'brand', 57, 165, '' ],
    [ 'RotaTeq', 'brand', 57, 167, '' ],
    [ 'Rota drops', 'generic', 57, 0, '' ],

    // 294 RSV
    [ 'RSV', 'abbreviation', 294, 0, 'Respiratory syncytial virus' ],
    [ 'Abrysvo', 'brand', 294, 274, '' ],

    // 133 Shingles
    [ 'Herpes zoster', 'generic', 133, 0, '' ],
    [ 'Zoster', 'generic', 133, 0, '' ],
    [ 'RZV', 'abbreviation', 133, 0, '' ],
    [ 'Shingrix', 'brand', 133, 275, '' ],

    // 298 Tdap
    [ 'Boostrix', 'brand', 298, 272, '' ],
    [ 'Tdap booster', 'generic', 298, 0, '' ],
    [ 'TT', 'combination', 298, 0, 'Tdap contains tetanus; TT alone is a different vaccine' ],
    [ 'Td', 'combination', 298, 0, 'Tdap contains tetanus and diphtheria; Td alone is a different vaccine' ],

    // 55 Typhoid
    [ 'TCV', 'abbreviation', 55, 0, 'Typhoid conjugate vaccine' ],
    [ 'Typbar TCV', 'brand', 55, 169, '' ],
    [ 'Typbar', 'brand', 55, 169, '' ],
    [ 'Typhim Vi', 'brand', 55, 171, '' ],
    [ 'Typhim', 'brand', 55, 171, '' ],
    [ 'Typhiod', 'misspelling', 55, 0, '' ],
    [ 'Taifoid', 'misspelling', 55, 0, '' ],

    // 61 Yellow Fever
    [ 'YF', 'abbreviation', 61, 0, '' ],
    [ 'Stamaril', 'brand', 61, 333, '' ],
];
