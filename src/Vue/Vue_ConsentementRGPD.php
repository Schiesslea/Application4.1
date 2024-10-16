<?php

namespace App\Vue;

use App\Utilitaire\Vue_Composant;

class Vue_ConsentementRGPD extends Vue_Composant
{
    private string $msgErreur;

    public function __construct(string $msgErreur = "")
    {
        $this->msgErreur = $msgErreur;
    }

    function donneTexte(): string
    {
        $str = "
            <h1>Objet du traitement (finalité et base légale)</h1>
            <p>La société ABCD, dont le siège est situé à CONFIANCE (96 000), Rue la Transparence, dispose d’un site internet de vente en ligne. Ce site permet de recevoir les commandes de nos clients et les données collectées à cette occasion sont enregistrées et traitées dans un fichier clients.</p>
            <p>Ce fichier permet de :</p>
            <ul>
                <li>Gérer les commandes, le paiement et la livraison.</li>
                <li>Mener des opérations de marketing (fidélisation, promotions) et adresser des publicités par courriel auprès de nos clients qui ne s’y sont pas opposés ou qui l’ont accepté :</li>
                <ul>
                    <li>Sur des produits analogues à ceux qu’ils ont commandés.</li>
                    <li>Sur d’autres produits proposés par la société. Par exemple, si un client achète une robe, une crème pour le corps pourra lui être proposée.</li>
                </ul>
                <li>Transmettre les données de nos clients qui l’ont accepté à nos partenaires commerciaux, pour leur permettre de leur adresser de la publicité (cf. ci-dessous).</li>
            </ul>
            <h2>Bases légales des traitements</h2>
            <ul>
                <li>Gestion des commandes : la base légale du traitement est l’exécution d’un contrat (Cf. article 6.1.b) du Règlement européen sur la protection des données).</li>
                <li>Envoi de sollicitations commerciales par courriel sur des produits analogues à ceux commandés par les clients : la base légale du traitement est l’intérêt légitime de la société (Cf. article 6.1.f) du Règlement européen sur la protection des données), à savoir promouvoir nos produits auprès de nos clients.</li>
                <li>Envoi de sollicitations commerciales par courriel sur d’autres produits proposés par la société ABCD : la base légale du traitement est le consentement (Cf. article 6.1.a) du Règlement européen sur la protection des données), comme l’exige l’article L. 34-5 du code des postes et des communications électroniques.</li>
                <li>Transmission de l’adresse électronique aux partenaires commerciaux : la base légale du traitement est le consentement (Cf. article 6.1.a) du Règlement européen sur la protection des données), comme l’exige l’article L. 34-5 du code des postes et des communications électroniques.</li>
            </ul>
            <h2>Catégories de données</h2>
            <ul>
                <li>Identité : civilité, nom, prénom, adresse, adresse de livraison, numéro de téléphone, adresse électronique, date de naissance, code interne de traitement permettant l'identification du client, données relatives à l’enregistrement sur des listes d’opposition.</li>
                <li>Données relatives aux commandes : numéro de la transaction, détail des achats, montant des achats, données relatives au règlement des factures (règlements, impayés, remises), retour de produits.</li>
                <li>Données relatives aux moyens de paiement : numéro de carte bancaire, date de fin de validité de la carte bancaire, cryptogramme visuel (lequel est immédiatement effac��).</li>
                <li>Données nécessaires à la réalisation des actions de fidélisation et de prospection : historique des achats.</li>
            </ul>
            <h2>Destinataires des données</h2>
            <ul>
                <li>Les services clients et facturation de la société ABCD sont destinataires de l’ensemble des catégories de données.</li>
                <li>Ses sous-traitants, chargés de la livraison de ses commandes, sont destinataires de l’identité, de l’adresse et du numéro de téléphone de nos clients.</li>
                <li>Les adresses électroniques des clients qui l’ont accepté sont mises à disposition de nos partenaires commerciaux (liste des partenaires commerciaux, régulièrement mise à jour) :</li>
                <ul>
                    <li>société X</li>
                    <li>société Y</li>
                    <li>société Z</li>
                </ul>
            </ul>
            <h2>Durée de conservation des données</h2>
            <ul>
                <li>Données nécessaires à la gestion des commandes et à la facturation : pendant toute la durée de la relation commerciale et dix (10) ans au titre des obligations comptables.</li>
                <li>Données nécessaires à la réalisation des actions de fidélisation et à la prospection : pendant toute la durée de la relation commerciale et trois (3) ans à compter du dernier achat.</li>
                <li>Données relatives aux moyens de paiement : ces données ne sont pas conservées par la société ABCD ; elles sont collectées lors de la transaction et sont immédiatement supprimées dès le règlement de l’achat.</li>
                <li>Données concernant les listes d'opposition à recevoir de la prospection : trois (3) ans.</li>
            </ul>
            <h2>Vos droits</h2>
            <p>Si vous ne souhaitez plus recevoir de publicité de la part de la société ABCD (exercice du droit d’opposition ou retrait d’un consentement déjà donné), contactez-nous (prévoir ici un lien vers un formulaire d’exercice des droits informatique et libertés, faisant apparaître les différents hypothèses détaillées ci-dessus).</p>
            <p>Si, après avoir consenti à ce que vos données soient transmises à nos partenaires commerciaux, vous souhaitez revenir sur ce choix et ne plus recevoir publicité de leur part, contactez-nous (prévoir ici un lien vers le formulaire d’exercice des droits informatique et libertés).</p>
            <p>(NB : un lien permettant aux clients et prospects de demander la suppression de leur adresse électronique de la liste de prospection doit systématiquement figurer sur les sollicitations envoyées par courriel)</p>
            <p>Vous pouvez accéder aux données vous concernant, les rectifier ou les faire effacer. Vous disposez également d'un droit à la portabilité et d’un droit à la limitation du traitement de vos données (Consultez le site cnil.fr pour plus d’informations sur vos droits).</p>
            <p>Pour exercer ces droits ou pour toute question sur le traitement de vos données dans ce dispositif, vous pouvez contacter notre DPO.</p>
            <p>Contacter notre DPO par voie électronique : dpo@abcd.fr</p>
            <p>Contacter notre DPO par courrier postal :</p>
            <p>Le délégué à la protection des données</p>
            <p>Société ABCD</p>
            <p>Rue la Transparence</p>
            <p>96 000 CONFIANCE</p>
            <p>(NB : si vous n’avez pas de DPO, indiquez des coordonnées précises où exercer ces droits dans l’entreprise).</p>
            <p>Si vous estimez, après avoir contacté la société ABCD, que vos droits « Informatique et Libertés » ne sont pas respectés, vous pouvez adresser une réclamation en ligne à la CNIL.</p>
        ";

        $str .= '
            <form method="post" action="index.php?action=AccepterRGPD">
                <h1>Consentement RGPD</h1>
                <p>Veuillez accepter les termes du RGPD pour continuer.</p>
                <input type="checkbox" name="aAccepteRGPD" value="1" required> J\'accepte les termes du RGPD<br>
                <button type="submit">Accepter</button>
            </form>
            <form method="post" action="index.php?action=RefuserRGPD">
                <button type="submit">Refuser</button>
            </form>
        ';

        return $str;
    }
}