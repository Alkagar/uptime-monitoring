<?php

    class SiteController extends Controller
    {
        public function actionIndex()
        {
            // renders the view file 'protected/views/site/index.php'
            // using the default layout 'protected/views/layouts/main.php'

            //$ping = new APing('erk.uj.edu.pl', 80);
            //$ping->monitor();

            //$pdf = new APdf('http://erk.kibeth:23480/uptime/pdf');
            //$pdf->monitor();

            //$db = new ADb('http://erk.kibeth:23480/uptime/db');
            //$db->monitor();

            //$db = new ASpace('http://erk.kibeth:23480/uptime/space', 512000);
            //$db->monitor();

            //$db = new AOverload('http://erk.kibeth:23480/uptime/errors');
            //$db->monitor();

            //$db = new ABreak('http://erk.kibeth:23480/uptime/errors');
            //$db->monitor();

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
