<?php

namespace Em\BackendBundle\Repository;
use Em\BackendBundle\Entity\Chambre;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * ChambreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChambreRepository extends \Doctrine\ORM\EntityRepository
{

    public function typeChambre($agences, $slugchambre){

        $qb = $this->createQueryBuilder('c');
        $qb->select('c');
        $qb->where('c.agences = :agences');
        $qb->andWhere('c.slugchambre = :slugchambre');
        $qb->setParameters(array('agences' => $agences , 'slugchambre' => $slugchambre));
        // $qb->setMaxResults(1);
        if($qb->getQuery()->getResult() == null){
            throw new NotFoundHttpException('Veuillez créer une chambre de ce type si votre agence en possède !');
        }
        return  $qb->getQuery()->getSingleResult();
    }

  /*  public function typeChambreBlock($agences, $slugchambre){

        $qb = $this->createQueryBuilder('c');
        $qb->select('c');
        $qb->where('c.agences = :agences');
        $qb->andWhere('c.slugchambre = :slugchambre');
        $qb->setParameters(array('agences' => $agences , 'slugchambre' => $slugchambre));

        if($qb->getQuery()->getResult() == null){
            //si la requete return zero alors en initialise total chambre de ce type
            $entity = new Chambre();
            $entity->setTotalchambre(0);

            return $entity;
        }
        return  $qb->getQuery()->getSingleResult();

    }
*/
    public function  typeChambreBlock($agences, $slugchambre){
        $qb = $this->createQueryBuilder('a');
        $qb->select('SUM(a.totalchambre) as somchambre')
           ->where('a.agences = :agences')
            ->andWhere('a.slugchambre = :slugchambre')
            ->setParameters(array(
                'agences' => $agences ,
                'slugchambre' => $slugchambre
            ));
        $som = ($qb->getQuery()->getOneOrNullResult() == null) ? 0 : $qb->getQuery()->getOneOrNullResult() ;
        return   $som;

    }

    //liste hotels

    public function  reupAgence(){
        $qb = $this->createQueryBuilder('c');
        $qb->select('c');
        $qb->join('c.agences', 'a')
            ->addSelect('a');
        $qb->where('a.locked = :locked');
        $qb->andwhere('c.locked = :locked');
        $qb->setParameter('locked' , false);
        $qb->orderBy('a.grade' , 'DESC');
        return $qb->getQuery()->getResult();
    }

    //liste hotels par etaoiles
    public function  reupAgenceGrade($grade){
        $qb = $this->createQueryBuilder('c');
        $qb->select('c');
        $qb->join('c.agences', 'a')
            ->addSelect('a');
        $qb->where('a.locked = :locked');
        $qb->andWhere('a.grade = :grade');
        $qb->andwhere('c.locked = :locked');
        $qb->setParameters(array('locked' => false, 'grade'=> $grade));
        $qb->orderBy('a.grade' , 'DESC');
        $qb->distinct(true);

       // var_dump($qb->getQuery()->getResult());die;
        return $qb->getQuery()->getResult();


    }
    //liste hotel par ville
    public function  reupAgencebyville($ville){
        $qb = $this->createQueryBuilder('c');
        $qb->select(array('c','a', 'v'));
        $qb->join('c.agences', 'a');
        $qb->join('a.villes', 'v');
        $qb->where('a.locked = :locked');
        $qb->andwhere('c.locked = :locked');
        $qb->andwhere('v.slug = :slug');
        $qb->setParameters(array('locked' => false, 'slug' => $ville));
        $qb->orderBy('a.grade' , 'DESC');
        return $qb->getQuery()->getResult();
    }

    //page details hotel
    public function  recupAgenceChambre($agence){
        $qb = $this->createQueryBuilder('c');
        $qb->select('c');
        $qb->join('c.agences', 'a')
            ->addSelect('a');
        $qb->where('a.locked = :locked');
        $qb->andwhere('c.locked = :locked');
        $qb->andwhere('c.agences = :agences');
        $qb->setParameters(array('locked' => false, 'agences' => $agence));

        return  $qb->getQuery()->getResult();
    }
    //page details hotel
    public function  recupAgenceAllChambre($agence){
        $qb = $this->createQueryBuilder('c');
        $qb->select('c');
        $qb->join('c.agences', 'a')
            ->addSelect('a');
        $qb->where('a.locked = :locked');
        $qb->andwhere('c.locked = :locked');
        $qb->andwhere('c.agences = :agences');
        $qb->setParameters(array('locked' => false, 'agences' => $agence));

        return  $qb->getQuery()->getResult();
    }
    public function  reupAgencebyetoile($grade){
        $qb = $this->createQueryBuilder('c');
        $qb->select(array('c','a', 'v'));
        $qb->join('c.agences', 'a');
        $qb->join('a.villes', 'v');
        $qb->where('a.locked = :locked');
        $qb->andwhere('c.locked = :locked');
        $qb->andwhere('a.grade = :grade');
        $qb->setParameters(array('locked' => false, 'grade' => $grade));
        $qb->orderBy('a.grade' , 'DESC');
        return $qb->getQuery()->getResult();
    }


}
