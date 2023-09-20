<?php
/**
* Plugin Name: form
* Description: Un plugin pour créer un formulaire d'enregistrement personnalisé.
* Version: 3.0
* Author: Anthony
*/

function create_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . "table_form";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        prenom text NOT NULL,
        nom text NOT NULL,
        date_de_naissance date NOT NULL,
        diplome_actuel text NOT NULL,
        niveau_etude text NOT NULL,
        formation text NOT NULL,
        ville text NOT NULL,
        mobilite int NOT NULL,
        text text,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_table');

function formu() {
    global $wpdb;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $data = array(
            'prenom'         => sanitize_text_field($_POST['prenom']),
            'nom'          => sanitize_text_field($_POST['nom']),
            'date_de_naissance'                => sanitize_text_field($_POST['date_de_naissance']),
            'diplome_actuel'    => sanitize_text_field($_POST['diplome_actuel']),
            'niveau_etude'=> sanitize_text_field($_POST['niveau_etude']),
            'formation'    => sanitize_text_field($_POST['formation']),
            'ville'               => sanitize_text_field($_POST['ville']),
            'mobilite'           => (int) $_POST['mobilite'], // Convertir en entier
            'text'          => sanitize_textarea_field($_POST['text'])
        );

        $wpdb->insert('wp_table_form', $data);
        
    }

    ob_start();
    ?>

    <form action="" method="post" id="form">

        <div>
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" required>
        </div>

        <div>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>
        </div>

        <div>
        <label for="date_de_naissance">Date de Naissance</label>
        <input type="date" id="date_de_naissance" name="date_de_naissance" required>
        </div>

        <div>
        <label for="diplome_actuel">Libellé du diplôme actuel</label>
        <input type="text" id="diplome_actuel" name="diplome_actuel" required>
        </div>

        <div>
        <label for="niveau_etude">Niveau d'études actuel</label>
        <input type="text" id="niveau_etude" name="niveau_etude" required>
        </div>

        <div>
        <label for="formation">Formation visée</label>
        <input type="text" id="formation" name="formation" required>
        </div>

        <div>
        <label for="ville">Ville d'habitation</label>
        <input type="text" id="ville" name="ville" required>
        </div>

        <div>
        <label for="mobilite">Mobilité (en kilomètres depuis le lieu de vie)</label>
        <input type="number" id="mobilite" name="mobilite" required>
        </div>

        <div>
        <label for="text">Texte libre</label>
        <textarea id="text" name="text"></textarea>
        </div>

        <input type="submit" name="submit" value="Envoyer">
    </form>

    <?php
    return ob_get_clean();

}
add_shortcode('form', 'formu');
