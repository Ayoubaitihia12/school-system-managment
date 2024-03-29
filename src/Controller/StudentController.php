<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\StudentType;
use App\Entity\Student;
use App\Form\StudentTypeUpdateType;
use App\Entity\Media;
use App\Model\StudentSearch;
use App\Form\StudentSearchType;

class StudentController extends AbstractController
{
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $studentSearch = new StudentSearch();

        $form = $this->createForm(StudentSearchType::class,$studentSearch);
        $form->handleRequest($request);

        $queryBuilder = $em->getRepository(Student::class)->createQueryBuilder('s');

        if($form->isSubmitted() && $form->isValid()){

            // dd($studentSearch);

            if(!empty($studentSearch->admission)){
                $queryBuilder->Where('s.admission LIKE :admission')
                ->setParameter('admission', '%'.$studentSearch->admission.'%');
            }

            if(!empty($studentSearch->name)){
                $queryBuilder->andWhere('s.FirstName LIKE :name')
                ->setParameter('name','%'.$studentSearch->name.'%');
            }

            if(!empty($studentSearch->class)){
                $queryBuilder->andWhere('s.class = :class')
                ->setParameter('class',$studentSearch->class);
            }
        }

        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('student/index.html.twig',[
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }

    public function add(Request $request , EntityManagerInterface $em , UserPasswordHasherInterface $passwordHasher): Response
    {
        $student = new Student();

        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $password = $student->getPassword();

            $hashedPassword = $passwordHasher->hashPassword(
                $student,
                $password
            );

            $student->setPassword($hashedPassword);
            
            $today = new \DateTime();
            $student->setAdmissionDate($today);

            // Create new Media:
            $media = new Media();


            if($student->getFile()){

                $media->setFile($student->getFile());

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
            

            $student->setImage($media);

            $em->persist($student);
            $em->flush();

            $this->addFlash('success','Student added successfully');

            return $this->redirectToRoute('app_students_index');
        }

        return $this->render('student/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function update(Request $request , EntityManagerInterface $em , Student $student): Response
    {
        $Updateform = $this->createForm(StudentTypeUpdateType::class,$student);
        $Updateform->handleRequest($request);

        if($Updateform->isSubmitted() && $Updateform->isValid()){

            if($student->getFile()){

                $media = new Media();
                $oldmedia = $student->getImage();

                $media->setFile($student->getFile());

                $media->upload($this->getParameter('files_directory'));

                $em->persist($media);
                $em->flush();

                $student->setImage($media);
                $em->flush();

                if($oldmedia){

                    $oldmedia->delete($this->getParameter('files_directory'));
                    
                    $em->remove($oldmedia);
                    $em->flush();  
                }
   
            }   
            
            $em->persist($student);
            $em->flush();

            $this->addFlash('success','Student updated successfully.');

            return $this->redirectToRoute('app_students_index');
        }

        return $this->render('student/update.html.twig',[
            'form' => $Updateform->createView()
        ]);
    }

    public function delete(EntityManagerInterface $em , Student $student)
    {
        $media = $student->getImage();

        $em->remove($student);
        $em->flush();

        if($media){
            $media->delete($this->getParameter('files_directory'));

            $em->remove($media);
            $em->flush();
        }

        $this->addFlash('success','Student deleted successfully');

        return $this->redirectToRoute('app_students_index');
    }

    public function view(Student $student): Response
    {
        return $this->render('student/view.html.twig',[
            'student' => $student
        ]);
    }
}
