<?php

namespace SearchBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * AgendaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
//use Doctrine\ORM\Mapping;

class SearchRepository extends \Doctrine\ORM\EntityRepository
{

    public function searchAction(){

        // on vérifie d'abord l'existence du POST et aussi si la requete n'est pas vide.
        if(isset($_POST['requete']) && $_POST['requete'] != NULL)

        {
            $bdd= new PDO('mysql:host=localhost;dbname=haras;charset=utf8', 'root', 'root');
//            $bdd = $this->getDoctrine()->getManager();

            // on crée une variable $requete pour faciliter l'écriture de la requête SQL,
            // mais aussi pour empêcher les éventuels malins qui utiliseraient du PHP ou du JS,
            // avec la fonction htmlspecialchars().
            $requete = htmlspecialchars($_POST['requete']);

            // la requête, que vous devez maintenant comprendre et modifier;)
            $query = $bdd->prepare("SELECT titre, contenu, nom 
                                    FROM post, categorie_plateforme 
                                    WHERE post.parent_id = categorie_plateforme.parent_id 
                                    AND contenu = $requete 
                                    OR titre = $requete 
                                    OR nom = $requete
                                    ORDER BY post.id DESC") OR DIE ();

            //on execute la requete
            $resultat = $query->execute(array(
                'requete' => $requete
            ));

            $donnees = $requete->fetch($query);

            // on utilise la fonction mysql_num_rows pour compter les résultats pour vérifier
//            $nb_resultats = count($result);

            // si le nombre de résultats est supérieur à 0, renvoie un résultat
            if($donnees != "")

            {
                // maintenant, on va afficher les résultats et la page qui les donne ainsi que
                // leur nombre, avec un peu de code HTML pour faciliter la tâche.
                return $this->render('@Search/Default/index.html.twig', array(
                    'query' => $donnees,
                    'nb_resultats' => $donnees,
                ));
            }
            // sinon on retourne à la page d'accueil avec un message
            else

            {
//                $this->addFlash(
//                    'success',
//                    'La recherche ne donne aucun résultats'
//                );

                return $this->render('@PlateForme/Default/index.html.twig');

            }
        }
        // Si le post est vide on retourne à la page d'accueil
        else
        {
//            $this->addFlash(
//                'success',
//                'Le champ de recherche est vide'
//            );

            return $this->render('@PlateForme/Default/index.html.twig', array(
                'query' => $post
            ));
        }

    }
}
