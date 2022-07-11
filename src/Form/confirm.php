<?php
namespace Drupal\assignment\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class confirm extends ConfirmFormBase {

    /**
     * ID of the item to delete.
     *
     * @var int
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, string $id = NULL) {
      $this->id = $id;
      return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      // @todo: Do the deletion.
      $db=\Drupal::database();

      $query = $db->delete('user_details')
      ->condition('id',$this->id)
      ->execute();

      $form_state->setRedirect('assignment.show');

    //  $abc=$this->redirect();


    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() : string {
      return "confirm_delete_form";
    }

    /**
     * {@inheritdoc}
     */
    public function getCancelUrl() {
      return new Url('assignment.show');
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestion() {
      return $this->t('Do you want to delete user %id ? ', ['%id' => $this->id]);
    }

    // public function redirect(){

    //     return new Url('hello_world.thirdpage');
    // }

  }
