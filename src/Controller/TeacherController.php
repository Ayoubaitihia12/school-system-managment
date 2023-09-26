<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Form\TeacherUpdateType;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Media;
use App\Form\TeacherSearchType;
use App\Model\TeacherSearch;

class TeacherController extends AbstractController
{

    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $teacherSearch = new TeacherSearch();

        $form = $this->createForm(TeacherSearchType::class,$teacherSearch);
        $form->handleRequest($request);

        $queryBuilder = $em->getRepository(Teacher::class)->createQueryBuilder('t');
        
        if($form->isSubmitted() && $form->isValid()){

            if(!empty($teacherSearch->admission)){
                $queryBuilder->Where('t.admissionId LIKE :admission')
                ->setParameter('admission', '%'.$teacherSearch->admission.'%');
            }

            if(!empty($teacherSearch->name)){
                $queryBuilder->andWhere('t.FirstName LIKE :name')
                ->setParameter('name','%'.$teacherSearch->name.'%');
            }

            if(!empty($teacherSearch->class)){
                $queryBuilder->andWhere('t.class = :class')
                ->setParameter('class',$teacherSearch->class);
            }
        }

        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('teacher/index.html.twig',[
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);

    }

    public function add(Request $request , EntityManagerInterface $em): Response
    {
        $teacher = new Teacher();

        $form = $this->createForm(TeacherType::class,$teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Create new Media:
            $media = new Media();


            if($teacher->getFile()){

                $media->setFile($teacher->getFile());

                $media->upload($this->getParameter('files_directory'));   

                $em->persist($media);
                $em->flush();

            }else{
                
                $file_name = md5(uniqid());
                $file_name =  $file_name.".jpeg";
                
                if (!file_exists($this->getParameter('files_directory')."jpg/")) {
                    mkdir($this->getParameter('files_directory')."jpg/");
                }
                
                copy($this->getParameter('files_directory')."/../img/defaultProfile.jpg", $this->getParameter('files_directory')."jpg/".$file_name);

                sleep(1);

                $media->setTitle("defaultProfile.jpg");                  
                $media->setName($file_name);                    
                $media->setUrl($file_name);                    
                $media->setType("image/jpg");                
                $media->setExtension("jpg");                  
                
                $em->persist($media);
                $em->flush();
            }
            

            $teacher->setImage($media);
            
            $today = new \DateTime();
            $teacher->setJoiningDate($today);

            $em->persist($teacher);
            $em->flush();

            $this->addFlash('success','Teacher added successfully');

            return $this->redirectToRoute('app_teacher_index');
        }

        return $this->render('teacher/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $em , Teacher $teacher): Response
    {

        $update_form = $this->createForm(TeacherUpdateType::class,$teacher);
        $update_form->handleRequest($request);

        if($update_form->isSubmitted() && $update_form->isValid()){
            
            if($teacher->getFile()){

                $media = new Media();
                $oldmedia = $teacher->getImage();

                $media->setFile($teacher->getFile());

                $media->upload($this->getParameter('files_directory'));

                $em->persist($media);
                $em->flush();

                $teacher->setImage($media);
                $em->flush();

                if($oldmedia){

                    $oldmedia->delete($this->getParameter('files_directory'));
                    
                    $em->remove($oldmedia);
                    $em->flush();  
                }
   
            } 
            $today = new \DateTime();
            $teacher->setJoiningDate($today);

            $em->persist($teacher);
            $em->flush();

            $this->addFlash('success','Teacher updated successfully.');

            return $this->redirectToRoute('app_teacher_index');
        }

        return $this->render('teacher/update.html.twig',[
            'form' => $update_form->createView()
        ]);
    }

    public function delete(EntityManagerInterface $em , Teacher $teacher)
    {
        $media = $teacher->getImage();

        $em->remove($teacher);
        $em->flush();

        if($media){
            $media->delete($this->getParameter('files_directory'));

            $em->remove($media);
            $em->flush();
        }

        $this->addFlash('success','Teacher deleted successfully');

        return $this->redirectToRoute('app_teacher_index');
    }
}
