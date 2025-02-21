<?php

/**
 * Plugin Name: Bibliotheque
 * Description: A plugin to synchronize content from zotero API.
 * Version: 1.0.0
 * Author: Constant Bourgois
 * Author URI: https://constantbourgois.com
 * License: GPL2
 * Text Domain: bibliotheque
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * order posts by title
 *
 * @since 1.0.0
 * @param \WP_Query $query The WordPress query instance.
 */
function custom_query_callback($query)
{
    // Modify the posts query here
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
}
add_action('elementor/query/orderbytitle', 'custom_query_callback');

add_action('init', function () {
    register_post_type('bibliotheque', array(
        'labels' => array(
            'name' => 'oeuvres',
            'singular_name' => 'oeuvre',
            'menu_name' => 'Bibliothèque',
            'all_items' => 'Tous les oeuvres',
            'edit_item' => 'Modifier oeuvre',
            'view_item' => 'Voir oeuvre',
            'view_items' => 'Voir oeuvres',
            'add_new_item' => 'Ajouter oeuvre',
            'add_new' => 'Ajouter oeuvre',
            'new_item' => 'Nouveau oeuvre',
            'parent_item_colon' => 'oeuvre parent :',
            'search_items' => 'Rechercher oeuvres',
            'not_found' => 'Aucun oeuvres trouvé',
            'not_found_in_trash' => 'Aucun oeuvres trouvé dans la corbeille',
            'archives' => 'Archives des oeuvre',
            'attributes' => 'Attributs des oeuvre',
            'insert_into_item' => 'Insérer dans oeuvre',
            'uploaded_to_this_item' => 'Téléversé sur ce oeuvre',
            'filter_items_list' => 'Filtrer la liste oeuvres',
            'filter_by_date' => 'Filtrer oeuvres par date',
            'items_list_navigation' => 'Navigation dans la liste oeuvres',
            'items_list' => 'Liste oeuvres',
            'item_published' => 'oeuvre publié.',
            'item_published_privately' => 'oeuvre publié en privé.',
            'item_reverted_to_draft' => 'oeuvre repassé en brouillon.',
            'item_scheduled' => 'oeuvre planifié.',
            'item_updated' => 'oeuvre mis à jour.',
            'item_link' => 'Lien oeuvre',
            'item_link_description' => 'Un lien vers un oeuvre.',
        ),
        'public' => true,
        'supports' => array('title', 'thumbnail'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-post',
        'has_archive' => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => ["slug" => "bibliotheque", "with_front" => false],
        "query_var" => true,
        'delete_with_user' => false,
    ));
});

add_action('init', function () {
    register_taxonomy('collection', ['bibliotheque'], array(
        'labels' => array(
            'name' => 'collections',
            'singular_name' => 'collection',
            'menu_name' => 'collection',
            'all_items' => 'Tous les collections',
            'edit_item' => 'Modifier collection',
            'view_item' => 'Voir collection',
            'update_item' => 'Mettre à jour collection',
            'add_new_item' => 'Ajouter collection',
            'new_item_name' => 'Nom du nouveau collection',
            'search_items' => 'Rechercher collection',
            'popular_items' => 'collection populaire',
            'separate_items_with_commas' => 'Séparer les collection avec une virgule',
            'add_or_remove_items' => 'Ajouter ou retirer collection',
            'choose_from_most_used' => 'Choisir parmi les collection les plus utilisés',
            'not_found' => 'Aucun collection trouvé',
            'no_terms' => 'Aucun collection',
            'items_list_navigation' => 'Navigation dans la liste collection',
            'items_list' => 'Liste collection',
            'back_to_items' => '← Aller à « collection »',
            'item_link' => 'Lien oeuvre',
            'item_link_description' => 'Un lien vers un oeuvre',
        ),
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "has_archive" => true,
        "rewrite" => ['slug' => 'collection', 'with_front' => true,]
    ));
});

add_action('init', function () {
    register_taxonomy('oeuvres_tag', ['bibliotheque'], array(
        'labels' => array(
            'name' => 'tags',
            'singular_name' => 'tag',
            'menu_name' => 'tag',
            'all_items' => 'Tous les tags',
            'edit_item' => 'Modifier tag',
            'view_item' => 'Voir tag',
            'update_item' => 'Mettre à jour tag',
            'add_new_item' => 'Ajouter tag',
            'new_item_name' => 'Nom du nouveau tag',
            'search_items' => 'Rechercher tag',
            'popular_items' => 'tag populaire',
            'separate_items_with_commas' => 'Séparer les tag avec une virgule',
            'add_or_remove_items' => 'Ajouter ou retirer tag',
            'choose_from_most_used' => 'Choisir parmi les tag les plus utilisés',
            'not_found' => 'Aucun tag trouvé',
            'no_terms' => 'Aucun tag',
            'items_list_navigation' => 'Navigation dans la liste tag',
            'items_list' => 'Liste tag',
            'back_to_items' => '← Aller à « tag »',
            'item_link' => 'Lien tag',
            'item_link_description' => 'Un lien vers un tag',
        ),
        "publicly_queryable" => true,
        "hierarchical" => false,
        "has_archive" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => ['slug' => 'tag', 'with_front' => true,]
    ));
});


/*
function delete_posts_in_batches() {
    $post_type = 'bibliotheque';
    $args = array(
        'post_type' => $post_type,
		'post_status' => 'publish',
        'posts_per_page' => 500, // Adjust the number of posts to delete per batch
        //'fields' => 'ids', // Retrieve only post IDs to improve performance
    );

    $posts = get_posts($args);

    if ($posts) {
        foreach ($posts as $post_id) {
            wp_delete_post($post_id->ID, true); // Set second parameter to true to force delete
        }
    }
} 

delete_posts_in_batches();*/


// set up cron to task

add_filter('cron_schedules', 'my_schedules');

function my_schedules($schedules)
{
    if (!isset($schedules["2min"])) {
        $schedules["2min"] = array(
            'interval' => 2 * 60,
            'display' => __('Once every 2 minutes')
        );
    }
    if (!isset($schedules["30min"])) {
        $schedules["30min"] = array(
            'interval' => 30 * 60,
            'display' => __('Once every 30 minutes')
        );
    }

    return $schedules;
}

if (!wp_next_scheduled('get_zotero_hook')) {
    wp_schedule_event(time(), 'hourly', 'get_zotero_hook');
}


add_action('get_zotero_hook', 'get_zotero_items');

function get_zotero_items()
{

    $args = array(
        'headers' => array(
            'Zotero-API-Key' => 'SECRET KEY'
        )
    );

    function getCollections($args)
    {
        $response = wp_remote_get('https://api.zotero.org/users/7368131/collections', $args);
        $json  = wp_remote_retrieve_body($response);
        $result = json_decode($json);
        return $result;
    }
    $collectionsData = getCollections($args);

    $start = 0;
    $itemsArrays = array();
    $resultCount = 1;

    while ($resultCount > 0) {
        $response = wp_remote_get('https://api.zotero.org/users/7368131/items?limit=100&start=' . $start, $args);
        $json  = wp_remote_retrieve_body($response);
        $result = json_decode($json);
        $resultCount = count($result);

        array_push($itemsArrays, $result);

        $start += 100;
    }

    foreach ($itemsArrays as $itemArray) {

        foreach ($itemArray as $index => $item) {

            $firstName = '';
            $lastName = '';
            // search of an existing item in the db
            $posts = get_posts(array(
                'posts_per_page'    => -1,
                'post_type'     => 'bibliotheque',
                'meta_key'      => 'key',
                'meta_value'    =>  $item->data->key
            ));
            if (empty($posts)) {

                // if there's none, create a post
                $id = wp_insert_post(array(
                    'post_title' => '',
                    'post_type' => 'bibliotheque',
                    'post_content' => '',
                    'post_status' => 'Publish'
                ));
            } else if (! empty($posts)) {
                $id = $posts[0]->ID;

                $current_item = array('ID' => $id, 'post_status' => 'Publish');

                wp_update_post($current_item, true);
                if (is_wp_error($id)) {
                    $errors = $id->get_error_messages();
                    foreach ($errors as $error) {
                        echo $error;
                    }
                }

                // publish posts

            }
            // insert data in acf fields
            if (isset($item->data->key)) {
                update_field('key', $item->data->key, $id);
            }
            if (isset($item->data->date)) {
                update_field('year', $item->data->date, $id);
            }
            if (isset($item->data->title)) {
                update_field('title', $item->data->title, $id);
                $post_update = array(
                    'ID'         => $id,
                    'post_title' => $item->data->title,
                    'post_name' => $item->data->title
                );

                $co = wp_update_post($post_update);
            }
            if (isset($item->data->url)) {
                update_field('url', $item->data->url, $id);
            }
            if (isset($item->data->place)) {
                update_field('place', $item->data->place, $id);
            }
            if (isset($item->data->publisher)) {
                update_field('publisher', $item->data->publisher, $id);
            }
            if (isset($item->data->numPages)) {
                update_field('numpages', $item->data->numPages, $id);
            }
            if (isset($item->data->abstractNote)) {
                update_field('abstractnote', $item->data->abstractNote, $id);
            }

            if (isset($item->data->tags) && count($item->data->tags) >= 0) {
                $tags = '';
                foreach ($item->data->tags as $key => $tag) {
                    $tags .= $tag->tag . ',';
                }
                if (substr($tags, -1, 1) === ',') {
                    $tags = substr_replace($tags, '', -1, 2);
                }
                wp_set_post_terms($id, $tags, 'oeuvres_tag');
                $tags = '';
            }

            if (isset($item->data->collections) && count($item->data->collections) >= 0) {
                $collections = '';

                foreach ($item->data->collections as $collectionId) {
                    foreach ($collectionsData as $value) {
                        if ($value->key  === $collectionId) {
                            $collections .= $value->data->name . ',';
                        }
                    }
                }
                if (substr($collections, -1, 1) === ',') {
                    $collections = substr_replace($collections, '', -1, 2);
                }
                wp_set_post_terms($id, $collections, 'collection');
            }



            if (isset($item->data->creators) && count($item->data->creators) === 1) {
                $firstName = isset($item->data->creators[0]->firstName) ? $item->data->creators[0]->firstName : '';
                $lastName = isset($item->data->creators[0]->lastName) ? $item->data->creators[0]->lastName : '';
                update_field('creators', $lastName . ' ' . $firstName, $id);
            } else if (isset($item->data->creators) && count($item->data->creators) > 1) {
                $creators_string = '';
                foreach ($item->data->creators as $key => $creator) {
                    if (isset($creator->firstName) && isset($creator->lastName)) {
                        $creators_string .= $creator->lastName . ' ' . $creator->firstName . ', ';
                    }
                    if (isset($creator->firstName) && isset($creator->lastName) === false) {
                        $creators_string .= $creator->firstName . ', ';
                    }
                    if (isset($creator->lastName) && isset($creator->firstName) === false) {
                        $creators_string .= $creator->lastName . ', ';
                    }
                }
                if (substr($creators_string, -2, 1) === ',') {
                    $creators_string = substr_replace($creators_string, '', -2, 2);
                }

                update_field('creators', $creators_string, $id);
                $creators_string = '';
            }
        }
    }
}
