<?php

   class SiteController extends Controller
   {
      public function actionIndex()
      {
         $suite = new AErkSuite();
         //$suite = new ARekrutacjaSuite();
         $suite->runSuite();

         $this->render('index');

         $logs = Logs::model()->findAll(Logs::getLastXCriteria(6));
         foreach($logs as $log) {
            echo $log . '<br />';
         }
      }

      /**
      * This is the action to handle external exceptions.
      */
      public function actionError()
      {
         if($error=Yii::app()->errorHandler->error)
         {
            if(Yii::app()->request->isAjaxRequest)
            echo $error['message'];
            else
            $this->render('error', $error);
         }
      }


      /**
      * Displays the login page
      */
      public function actionLogin()
      {
         $model=new LoginForm;

         // if it is ajax validation request
         if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
         {
            echo CActiveForm::validate($model);
            Yii::app()->end();
         }

         // collect user input data
         if(isset($_POST['LoginForm']))
         {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
            $this->redirect(Yii::app()->user->returnUrl);
         }
         // display the login form
         $this->render('login',array('model'=>$model));
      }

      /**
      * Logs out the current user and redirect to homepage.
      */
      public function actionLogout()
      {
         Yii::app()->user->logout();
         $this->redirect(Yii::app()->homeUrl);
      }
   }
