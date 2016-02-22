<?php

namespace AppBundle\Controller;

use AppBundle\Form\TaskType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Task;

class TaskController extends Controller
{

    /**
     *
     * Get a single Task.
     *
     * @ApiDoc(
     *   output = "AppBundle\Model\Task",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the task is not found"
     *   }
     * )
     * @param Request $request the request object
     * @return array
     */
    public function getTaskAction(Request $request,$id)
    {
        $task = $this->getDoctrine()
            ->getRepository('AppBundle:Task')
            ->find($id);

        if (!$task) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        $view = new View($task);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }

    /**
     *
     * List all tasks.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     */
    public function getTasksAction()
    {
        $task = $this->getDoctrine()
            ->getRepository('AppBundle:Task')
            ->findAll();

        if (!$task) {
            throw $this->createNotFoundException(
                'No Tasks found for id '
            );
        }
        $view = new View($task);
        $group = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $group));

        return $view;
    }

    /**
     * Creates a new task from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TaskType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View()
     *
     */
    public function postTasksAction(Request $request)
    {
        $task = new Task();
        $task->setCreated(date('Y-m-d') . 'T' . date('H:i:s'));
        $task->setModified(date('Y-m-d') . 'T' . date('H:i:s'));
        $form = $this->createForm(new TaskType(), $task);
        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }else{

        }
    }

    /**
     * Removes a Task.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the task id
     *
     */
    public function deleteTaskAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $task= $em->getRepository('AppBundle:Task')->find($id);
        $em ->remove($task);
        $em->flush();
    }

    /**
     * Update existing task from the submitted data or create a new task at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "AppBundle\Form\TaskType",
     *   statusCodes = {
     *     201 = "Returned when a new resource is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *   template="AppBundle:Task:editTask.html.twig",
     *   templateVar="form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the task id
     *
     */
    public function putTaskAction(Request $request, $id)
    {
        $task = $this->getDoctrine()
            ->getRepository('AppBundle:Task')
            ->find($id);
        if (false === $task || $task == null) {
            $task = new Task();
            $task->setCreated(date('Y-m-d') . 'T' . date('H:i:s'));
        }
            $task->setModified(date('Y-m-d') . 'T' . date('H:i:s'));

        $form = $this->createForm(new TaskType(), $task);

        $form->submit($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        }
    }
}
