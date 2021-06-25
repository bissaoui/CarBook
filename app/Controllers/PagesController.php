<?php

namespace App\Controllers;

use http\Message;

use mysql_xdevapi\Exception;

use mysql_xdevapi\Session;

use Psr\Http\Message\RequestInterface;

use Psr\Http\Message\ResponseInterface;

use Slim\Http\UploadedFile;

class PagesController extends Controller {

    public function TestConnection(){
        if(isset($_SESSION["user"])){
                return 1;
        }
        else return 2;
    }
    public function TestAdmin(){
        if(isset($_SESSION["user"]))
        if($_SESSION["user"]=="admin"){
                return 1;
        }
        else return 2;
    }
	public function home(RequestInterface $request , ResponseInterface $response)
	{
        $limit=5;
        $testAd=2;
        $test=$this->TestConnection();
        if($test){
            $testAd=$this->TestAdmin();
        }
        $req= $this->container->pdo->prepare('select count(*) from Annonce where statu=1');
        $req->execute();
        $count =$req->fetch();
        $pagination=intval( $count[0]/$limit);

        $req1= $this->container->pdo->prepare('SELECT a.titre, a.image,v.ville,a.PrixA ,a.idAn,a.datePub, a.img,a.visitor FROM Annonce a , User u ,`model` m ,`marque` ma ,`ville` v WHERE a.idVille=v.id and a.statu=1 and a.idUser=u.id and a.idModel=m.idModel and m.idM=ma.idM order by a.datePub desc limit 0,'.$limit.';');
        $req1->execute();
        $result =$req1->fetchAll();        
        
        $this->render($response,'layouts/home.twig',["v"=>$count[0],"req1"=>$result,"cnx"=>$test,"nbPage"=>$pagination,"testA"=>$testAd]);
    
    }
    public function pages(RequestInterface $request , ResponseInterface $response, $args)
	{
        
        $NbPage = intval( $args['page']);
      if (empty($NbPage))
        {
            return $response->withRedirect('/usedCars/public/index.php');
        }
        else{
            $req= $this->container->pdo->prepare('select count(*) from Annonce where statu=1');
            $req->execute();
            $count =$req->fetch();
        $limit=5;
        $skip = $NbPage*$limit;
     
        $testAd=2;
        $test=$this->TestConnection();
        $testAd=false;
        if($test){
            $testAd=$this->TestAdmin();
        }
                if($NbPage<$count[0]/$limit)
        {
            $pagination=intval( $count[0]/$limit);
            $req1= $this->container->pdo->prepare('SELECT a.titre, a.image,v.ville,a.PrixA ,a.idAn,a.datePub , a.img  FROM Annonce a , User u ,`model` m ,`marque` ma ,`ville` v WHERE a.statu=1 and a.idVille=v.id  and a.idUser=u.id and a.idModel=m.idModel and m.idM=ma.idM order by a.datePub desc limit '.$skip.','.$limit .';'
        );
        $req1->execute();
        $result =$req1->fetchAll();
         $this->render($response,'layouts/home.twig',["v"=>$count[0][0],"req1"=>$result,"cnx"=>$test,"nbPage"=>$pagination,"page"=>$NbPage,"testA"=>$testAd]);
        }
        else{
         return $response->withRedirect('/usedCars/public/index.php');
        }
    }
    }
    


    public  function  getAfficherAnnonce(RequestInterface $request , ResponseInterface $response)
    { 
        $test=$this->TestConnection();
        $testAd=2;
        if($test){
            $testAd=$this->TestAdmin();
        }
        $id=$_GET["idAnn"];
        $test=$this->TestConnection();
        $req1= $this->container->pdo->prepare('SELECT idAn FROM Annonce where idAn=:id');
        $req1->execute(array(":id"=>$id));
    
        if($req1->rowCount()>0)
        {
        if(isset($_GET["idAnn"]  )&& $_GET["idAnn"]!="" ){
            $req21= $this->container->pdo->prepare('Update   Annonce  set visitor = 1 + visitor where idAn=:id');
            $req21->execute(array(":id"=>$id));
            $req0= $this->container->pdo->prepare('SELECT a.titre, a.image,a.infoA,u.username,a.telephone ,a.email,ma.libelleM,m.libelleMo,a.kilomitrage,a.dateConstruction,v.ville,a.PrixA , a.visitor FROM Annonce a , User u ,`model` m ,`marque` ma,`ville`v WHERE idAn=:id and v.id=a.idVille and  a.idUser=u.id and a.idModel=m.idModel and m.idM=ma.idM');
        $req0->execute(array(":id"=>$id));
        $result =$req0->fetch();

        $images = explode(",",$result[1]);
        $count=Count($images);
        
        $this->render($response,'layouts/AfficherAnnonce.twig' ,["t"=>$result,"cnx"=>$test,"testA"=>$testAd,"img"=>$images,"count"=>$count]);
    }
}
    else{
        return $response->withRedirect('../');
    }
    }
    // Get  Et Post de  Modele
    public  function postModele(RequestInterface $request , ResponseInterface $response)
    {
        $test=$this->TestConnection();
        $testAd=2;
        if($test){
            $testAd=$this->TestAdmin();
        }
        $params =$request->getParsedBody();
        $marque=$params["marque"];
        $modele=$params["modele"];
        $req= $this->container->pdo->prepare('select * from model where libelleMo=:modele and idM=:marque');
        $req->execute(array(':marque'=>$marque,':modele'=>$modele));
        $row_cnt = $req->rowCount(); ;
        if($row_cnt>0)
        {
            $stat="Non Ajoute";
            $clasStat="badge badge-danger";

            echo "<script> alert('existe deja ');</script>";
        }
        else{
            $stat="Ajoute avec succès";
            $clasStat="badge badge-success";
            $req2=$this->container->pdo->prepare('INSERT INTO `model` (`libelleMo`, `idM`) VALUES (:modele,:marque);');
            $req2->execute(array(':marque'=>$marque,':modele'=>$modele));
        }
        $req1= $this->container->pdo->prepare('select * from marque');
        $req1->execute();
        $result=$req1->fetchAll();
        $this->render($response,'layouts/AjouterModele.twig',['v'=>"<span class='$clasStat'>$stat</span>","req"=>$result,"cnx"=>$test,"testA"=>$testAd]);

    }
    public  function getModele(RequestInterface $request , ResponseInterface $response){
        if (isset($_SESSION['user'])) {
            $test=$this->TestConnection();
            $testAd=2;
            if($test){
                $testAd=$this->TestAdmin();
            }

            $req1= $this->container->pdo->prepare('select * from marque');
            $req1->execute();
            $result=$req1->fetchAll();
            $this->render($response,'layouts/AjouterModele.twig',["req"=>$result,"cnx"=>$test,"testA"=>$testAd]);
        }else{
            return $response->withRedirect('loginU');
        }
    }
    // get et post de Marque 
    // Get 
    public  function getMarque(RequestInterface $request , ResponseInterface $response){
        if (isset($_SESSION['user'])) {

            $test=$this->TestConnection();
            $testAd=2;
            if($test){
                $testAd=$this->TestAdmin();
            }

            $this->render($response,'layouts/ajouterMarque.twig',["cnx"=>$test,"testA"=>$testAd]);
        }else{
            return $response->withRedirect('loginU');
        }
    }
    //Post
    public function postMarque(RequestInterface $request , ResponseInterface $response){
        if (isset($_POST["marque"])) {
            $test=$this->TestConnection();
            $testAd=2;
            if($test){
                $testAd=$this->TestAdmin();
            }
            $params =$request->getParsedBody();
        $marque=$params["marque"];
        $req= $this->container->pdo->prepare('select * from marque where libelleM=:marque');
        $req->execute(array(':marque'=>$marque));
        $row_cnt = $req->rowCount(); ;
        if($row_cnt>0)
        {
            echo "<script> alert('existe deja ');</script>";
            $this->render($response,'layouts/ajouterMarque.twig',['v'=>"<span class='badge badge-danger'>Non Ajoute</span>","cnx"=>$test,"testA"=>$testAd]);

        }else
        {
            $req1= $this->container->pdo->prepare('INSERT INTO `marque`(`libelleM`) VALUES (:marque);');
            $req1->execute(array(':marque'=>$marque));
            echo "<script> alert('Bien Ajouter ');</script>";
            $this->render($response,'layouts/ajouterMarque.twig',['v'=>"<span class='badge badge-success'>Ajoute avec succès</span>","cnx"=>$test,"testA"=>$testAd]);

        }
    }
	}
// Post et Get Admin
// Get Admin : 
public function getLogin(RequestInterface $request , ResponseInterface $response)
{
    $this->render($response,'layouts/login.twig');
}
// Post Admin
public function postLogin(RequestInterface $request , ResponseInterface $response ,$args)
{
    $params =$request->getParsedBody();
    $name=$params["name"];
    $password=$params["password"];
    $req =$this->container->pdo->prepare('SELECT * FROM User u,UserEst e where username=:name and password=:password and e.idRole=1 and e.idUser=u.id');
    $req->execute(array(':password'=>$password ,':name'=>$name));
    $row_cnt = $req->rowCount(); ;
    if ($row_cnt>0) {
        $req1 = $this->container->pdo->prepare('SELECT u.* FROM User u ,UserEst e where e.idRole=2 and u.id=e.idUser;');
        $req1->execute();
        return  $this->container->view->render($response,'layouts/AdminLog.twig',["req"=>$req1]);
    }
         return  $this->container->view->render($response,'layouts/login.twig');
}
  // Post et get d'utilisateur
  // Get User :
  public function getLoginU(RequestInterface $request , ResponseInterface $response)
    {
        if (isset($_SESSION['user'])) {
                if($_SESSION['user']=="admin")
                {
                    return $response->withRedirect('PageAdmin');

                }
                else

            return $response->withRedirect('PageUser');
        }else{
            return $this->render($response, 'layouts/loginUser.twig');
        }
    }
    //Post User :
    public function postLoginU(RequestInterface $request , ResponseInterface $response ,$args)
    {
        $params =$request->getParsedBody();
        $name=$params["name"];
        $password=$params["password"];
        $req =$this->container->pdo->prepare('SELECT * FROM User where   username=:name and password=:password');
        $req->execute(array(':password'=>$password ,':name'=>$name));
        $row_cnt = $req->rowCount();
           if ($row_cnt>0) {
               $_SESSION['user']=$name;
               if($name !="admin")
               return $response->withRedirect('PageUser');
               else{
               return $response->withRedirect('PageAdmin');
               }
           }
            return  $this->container->view->render($response,'layouts/loginUser.twig',["erreur"=>"Password ou username incorrect"]);
    }

    public function  getPageAdmin(RequestInterface $request , ResponseInterface $response)
    {
        if (isset($_SESSION['user'])){
            if($_SESSION['user']=="admin"){
        $this->container->view->render($response,'layouts/AdminLog.twig',["session"=>$_SESSION['user']]);
            }
        }
    }
    public function getPageAdminGestionAnonnce(RequestInterface $request , ResponseInterface $response)
    {
        if (isset($_SESSION['user'])){
            
            
            if($_SESSION['user']=="admin"){
                $test=$this->TestConnection();
                $testAd=2;
                if($test){
                    $testAd=$this->TestAdmin();
                }
                if(isset($_GET['do'])){
           $do=isset($_GET['do']) ? $_GET['do'] : "";
           $req= $this->container->pdo->prepare('SELECT * FROM Annonce  WHERE idAn=:id');
           $req->execute(array(":id"=>$_GET['idItem']));
           $Rowcount=$req->rowCount();
        
            if($do=="edit" && $Rowcount>0){
                $iditem=$_GET['idItem'];
                $req= $this->container->pdo->prepare('SELECT a.titre, a.image,a.infoA,u.username,a.telephone ,a.email,ma.libelleM,m.libelleMo,a.kilomitrage,a.dateConstruction,v.ville,a.PrixA FROM Annonce a , User u ,`model` m ,`marque` ma,`ville` v WHERE v.id=a.idVille and a.idAn=:id and a.idUser=u.id and a.idModel=m.idModel and m.idM=ma.idM
                ');
                $req->execute(array(":id"=>$iditem));
                $result =$req->fetchAll();
                $req2 = $this->container->pdo->prepare('SELECT * FROM marque ');
                $req2->execute();
                $result11=$req2->fetchAll();
                $req1 = $this->container->pdo->prepare('SELECT * FROM model ');
                $req1->execute();
                $result1=$req1->fetchAll();
                $req11= $this->container->pdo->prepare('select * from ville order by ville asc');
                $req11->execute();
                $result21=$req11->fetchAll();
                return  $this->container->view->render($response,'layouts/ModifierAnnonce.twig',["reqq"=>$result21,"id"=>$iditem,"r"=>$result,"req"=>$result11,"req1"=>$result1,"cnx"=>$test,"testA"=>$testAd]);
            }     else if (isset($_GET['do'])=="edit" && $Rowcount<=0){
                echo '<script> alert("erreur");</script>';
            }
            else  if($do=="delete"){
                $item=isset($_GET['idItem']) && is_numeric($_GET['idItem']) ? intval($_GET['idItem']) : 0 ;
                $requet1=$this->container->pdo->prepare('Delete FROM Annonce where idAn=:idItem');
                $requet1->execute(array(':idItem' => $item));
            }
            else if($do=="show"){
                $item=isset($_GET['idItem']) && is_numeric($_GET['idItem']) ? intval($_GET['idItem']) : 0 ;
                $requet1=$this->container->pdo->prepare('Update Annonce set statu=1 where idAn=:idItem');
                $requet1->execute(array(':idItem' => $item));
            }  else if($do=="hide"){
                $item=isset($_GET['idItem']) && is_numeric($_GET['idItem']) ? intval($_GET['idItem']) : 0 ;
                $requet1=$this->container->pdo->prepare('Update Annonce set statu=0 where idAn=:idItem');
                $requet1->execute(array(':idItem' => $item));
            }
        }
            
            //Requete INFO ANNONCE :
            $req1 = $this->container->pdo->prepare('SELECT a.idAn,a.titre,a.PrixA,m.libelleM,a.statu,u.username,a.visitor FROM Annonce a , model mo ,marque m,User u where  u.id=a.idUser and a.idModel=mo.idModel and mo.idM=m.idM order by a.statu asc');
            $req1->execute();
            $result2=$req1->fetchAll();
            // Requete Liste marque
            $this->container->view->render($response,'layouts/GestionAnnonce.twig',["req"=>$result2,"session"=>$_SESSION['user'],"cnx"=>$test,"testA"=>$testAd]);
        }else
        return $response->withRedirect('PageUser');

        }
        else
        $this->render($response,'layouts/loginUser.twig');

    

        }
    

    // Post et get d'ajout les annonces :
    //Get Ajoute :
    public function getAjouteAn(RequestInterface $request , ResponseInterface $response)
    {
        if (isset($_SESSION['user'])) {
            $testAd=$this->TestAdmin();
            $testCnx=$this-> TestConnection();
            $req2 = $this->container->pdo->prepare('SELECT * FROM marque ');
            $req2->execute();
            $result11=$req2->fetchAll();
            $req1 = $this->container->pdo->prepare('SELECT * FROM model ');
            $req1->execute();
            $result1=$req1->fetchAll();
            $req11= $this->container->pdo->prepare('select * from ville order by ville asc');
            $req11->execute();
            $result21=$req11->fetchAll();
            $this->render($response,'layouts/AjouterAnnonce.twig',["req"=>$result11,"req1"=>$result1,"testA"=>$testAd,"cnx"=>$testCnx,"ville"=>$result21]);

        }else{
            return $response->withRedirect('loginU');
        }
    }
    //Post Ajoute :
    public function postAjouteAn(RequestInterface $request , ResponseInterface $response)
    {

        if (isset($_SESSION['user'])) {
            $test=$this->TestConnection();
            $testAd=2;
            if($test){
                $testAd=$this->TestAdmin();
            }
            if (isset($_POST["titre"])) {
                $existe="n'existe pas cette type de voiture ";
            $params = $request->getParsedBody();
             $titre = $params["titre"];
            $email = $params["email"];
            $tele = $params["tele"];
            $ville = $params["ville"];
            $marque = $params["marque"];
            $model = $params["model"];
            $kilomitrage=$params["kilomitrage"];
            $req20 = $this->container->pdo->prepare('SELECT * FROM marque ');
            $req20->execute();
               $result110=$req20->fetchAll();
            $req10 = $this->container->pdo->prepare('SELECT * FROM model ');
           $req10->execute();
           $result10=$req10->fetchAll();

            $req5=$this->container->pdo->prepare("Select * from model where idModel=:model and idM=:marque");
            $req5->execute(array(':model'=>$model,':marque'=>$marque));
            $row_cont=$req5->rowCount();
            $req11= $this->container->pdo->prepare('select * from ville order by ville asc');
            $req11->execute();
            $result21=$req11->fetchAll();
                if($row_cont>0){
                    $existe="erreur au niveau d'image";
                    $annee=$params["annee"];
                    $desc=$params["desc"];
                    $prix = $params["prix"];
                    $directory = "photos";
                    $uploadedFiles = $request->getUploadedFiles();
                    $uploadedFile = $uploadedFiles['image'];
                    function moveUploadedFile($directory, UploadedFile $uploadedFile){
                        $extension = pathinfo($uploadedFile->getClientFilename(),
                        PATHINFO_EXTENSION);
                        $basename = bin2hex(random_bytes(8));
                        $filename = sprintf('%s.%0.8s', $basename, $extension);
                        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
                        return $filename;
                    }
                    $imag=array();
                    foreach ($uploadedFiles['image'] as $uploadedFile) {
                        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                            $filename = moveUploadedFile($directory, $uploadedFile);
                            $imag[]=$filename;
                            $existe="Annonce bien Ajouter en attende de verification ";

                        }
                    }
                    $imgg=$imag[0];
                    $imag = implode(",", $imag);
                   /* if($uploadedFile->getError() === UPLOAD_ERR_OK) {
                        $filename = moveUploadedFile($directory, $uploadedFile);
                    }*/
                        $req3 = $this->container->pdo->prepare('SELECT * FROM User where username=:name');
                        $req3->execute(array(':name' => $_SESSION['user']));
                        $affiche = $req3->fetchAll();
                       
                    

                        $dbquery2 = $this->container->pdo->prepare("INSERT INTO `Annonce` (`titre`, `infoA`, `idUser`, `idModel`, `PrixA`,`image`,`telephone`, `dateConstruction`, `idVille`,`email`,`kilomitrage`,`datePub`,`img`) VALUES (:titre,:desc,:idU,:model,:prix,:image,:tele,:annee,:ville,:email,:kilomitrage,NOW(),:img)");
                        $dbquery2->execute(array(':idU' => $affiche[0][0], ':titre' => $titre, ':desc' => $desc, ':model' => $model, ':prix' => $prix,":image"=>$imag,":annee"=>$annee,":ville"=>$ville ,":email"=>$email,":tele"=>$tele,":kilomitrage"=>$kilomitrage,":img"=>$imgg));
                        $this->render($response,'layouts/AjouterAnnonce.twig',["existe"=> $existe,"testA"=>$testAd,"cnx"=>$test,"req"=>$result110,"req1"=>$result10, "ville"=>$result21]);

                    }
                    else{
                        $this->render($response,'layouts/AjouterAnnonce.twig',["existe"=> $existe,"testA"=>$testAd,"cnx"=>$test,"req"=>$result110,"req1"=>$result10,"ville"=>$result21]);

                    }

            }
        }
    } 

    public function postRecherche(RequestInterface $request , ResponseInterface $response )
    { 
       
        $test=$this->TestConnection();
        $testAd=2;
        if($test){
            $testAd=$this->TestAdmin();
        }
        $prix="desc";
       // if (isset($_POST["ville"]!=)){}
        $params = $request->getParsedBody();
        $ville = $params["ville"]; 
        $marque =$params["marque"]; 
        $prix = $params["prix"]; 
        $select="and ";
   
        if($ville!="")
            $select .=" a.idVille= '".$ville."'";

            if($ville=="x")
            $select="and ";


        if($marque!="x")
            if($select!="and ")
            $select .=" and ma.idM= ".$marque;
            else
            $select .=" ma.idM= ".$marque;
         if($select!="and "){
            if($prix!="")
            $select.=" order by a.PrixA ".$prix;
        }
            else 
            if ($prix=="desc")
            $select=" order by a.PrixA ".$prix;
            if (    $select=="and "
            ){
                $select="";

            }

        $req12= $this->container->pdo->prepare('select * from marque');
        $req12->execute();
        $result22=$req12->fetchAll();
        $req11= $this->container->pdo->prepare('select * from ville');
        $req11->execute();
        $result21=$req11->fetchAll();
       $req1= $this->container->pdo->prepare('SELECT a.titre, a.image,v.ville,a.PrixA ,a.idAn,a.datePub,a.img FROM Annonce a , User u ,`model` m ,`marque` ma,`ville` v WHERE a.statu=1 and a.idUser=u.id and a.idModel=m.idModel and a.idVille=v.id  and m.idM=ma.idM '.$select);
        $req1->execute();
        $result =$req1->fetchAll();
        $test=$this->TestConnection();
        $this->render($response,'layouts/Recherche.twig',["req"=>$result22,"req1"=>$result,"cnx"=>$test,"testA"=>$testAd,"ville"=>$result21]);

    }
    public function getRecherche(RequestInterface $request , ResponseInterface $response )
    { 
   
        $test=$this->TestConnection();
        $testAd=2;
        if($test){
            $testAd=$this->TestAdmin();
        }
        $req12= $this->container->pdo->prepare('select * from marque');
        $req12->execute();
        $result22=$req12->fetchAll();
        $req11= $this->container->pdo->prepare('select * from ville');
        $req11->execute();
        $result21=$req11->fetchAll();

        $this->render($response,'layouts/Recherche.twig',["req"=>$result22,"cnx"=>$test,"testA"=>$testAd,"ville"=>$result21]);

    }    
    
    //Post et Get Modifier Annonce 

        //Get Modifier Annonce 

   
    //Post Modifier Annonce 
    public function postModifierAn(RequestInterface $request , ResponseInterface $response)
    {
        if (isset($_SESSION['user'])) {
            if (isset($_POST["titre"])) {
            $params = $request->getParsedBody();
             $titre = $params["titre"];
            $email = $params["email"];
            $tele = $params["tele"];
            $ville = $params["ville"];
            $marque = $params["marque"];
            $model = $params["model"];
            $id=$params["id"];
            $kilomitrage=$params["kilomitrage"];
            $req5=$this->container->pdo->prepare("Select * from model where idModel=:model and idM=:marque");
            $req5->execute(array(':model'=>$model,':marque'=>$marque));
            $row_cont=$req5->rowCount();
                if($row_cont>0){
                        $annee=$params["annee"];
                        $desc=$params["desc"];
                        $prix = $params["prix"];
                        $req3 = $this->container->pdo->prepare('SELECT * FROM User where username=:name');
                        $req3->execute(array(':name' => $_SESSION['user']));
                        $affiche = $req3->fetchAll();
                        $dbquery2 = $this->container->pdo->prepare("UPDATE `Annonce` SET `titre`=:titre,`infoA`=:desc,`idModel`=:model,`PrixA`=:prix,`telephone`=:telephone,`dateConstruction`=:annee,`idVille`=:ville,`email`=:email,`kilomitrage`=:kilomitrage WHERE idAn=:id");
                        $dbquery2->execute(array(                                   ':titre' => $titre, ':desc' => $desc, ':model' => $model, ':prix' => $prix,":annee"=>$annee,":ville"=>$ville ,":email"=>$email,":telephone"=>$tele,":kilomitrage"=>$kilomitrage,":id"=>$id));
                    }
            }
            if (($_SESSION['user'])=="admin") {
                return $response->withRedirect('/usedCars/public/index.php/PageAdmin/GestionAnnonce');
            }
            else
        return $response->withRedirect('/usedCars/public/index.php/PageUser');
        }
    }
    // Get :  Dashbord User
    public function getPageU(RequestInterface $request , ResponseInterface $response)
    { 
        if (isset($_SESSION['user'])){
            $test=$this->TestConnection();
        $testAd=2;
            if($test){
                $testAd=$this->TestAdmin();
            }

           $do=isset($_GET['do']) ? $_GET['do'] : "";
           $req= $this->container->pdo->prepare('SELECT * FROM Annonce  WHERE idAn=:id');
           $req->execute(array(":id"=>$_GET['idItem']));
           $Rowcount=$req->rowCount();
           
            if($do=="edit" && $Rowcount>0){
                $iditem=$_GET['idItem'];
                $req= $this->container->pdo->prepare('SELECT a.titre, a.image,a.infoA,u.username,a.telephone ,a.email,ma.libelleM,m.libelleMo,a.kilomitrage,a.dateConstruction,v.ville,a.PrixA FROM Annonce a , User u ,`model` m ,`marque` ma, `ville` v WHERE v.id=a.idVille and a.idAn=:id and a.idUser=u.id and a.idModel=m.idModel and m.idM=ma.idM');
                $req->execute(array(":id"=>$iditem));
                $result =$req->fetchAll();
                $Rowcount=$req->rowCount();
                $req2 = $this->container->pdo->prepare('SELECT * FROM marque ');
                $req2->execute();
                $result11=$req2->fetchAll();
                $req1 = $this->container->pdo->prepare('SELECT * FROM model ');
                $req1->execute();
                $result1=$req1->fetchAll();
                $req11= $this->container->pdo->prepare('select * from ville order by ville asc');
                $req11->execute();
                $result21=$req11->fetchAll();
                return  $this->container->view->render($response,'layouts/ModifierAnnonce.twig',["reqq"=>$result21,"id"=>$iditem,"r"=>$result,"req"=>$result11,"req1"=>$result1,"cnx"=>$test,"testA"=>$testAd]);
            }
            else if (isset($_GET['do'])=="edit" &&  $Rowcount<=0){
                echo '<script> alert("erreur");</script>';
            }
            if($do=="delete"){
                $item=isset($_GET['idItem']) && is_numeric($_GET['idItem']) ? intval($_GET['idItem']) : 0 ;
                $requet1=$this->container->pdo->prepare('Delete FROM Annonce where idAn=:idItem');
                $requet1->execute(array(':idItem' => $item));
            }
            
            //Requete INFO ANNONCE :
            $req1 = $this->container->pdo->prepare('SELECT a.idAn,a.titre,a.PrixA,m.libelleM,a.statu FROM Annonce a , model mo ,marque m,User u where u.username=:name  and u.id=a.idUser and a.idModel=mo.idModel and mo.idM=m.idM');
            $req1->execute(array(':name'=>$_SESSION['user']));
            $result2=$req1->fetchAll();
            // Requete Liste marque
            $this->container->view->render($response,'layouts/PageUser.twig',["req"=>$result2,"session"=>$_SESSION['user'],"cnx"=>$test,"testA"=>$testAd]);
        }
        else
        $this->render($response,'layouts/loginUser.twig');

    }
    
    // Get Logout
    public function getLogout(RequestInterface $request , ResponseInterface $response){
	        session_destroy();
            return $this->render($response, 'layouts/loginUser.twig');
    }
// Post et get D'inscription d'utilisateur 
// Get Inscris :

public function getInscri(RequestInterface $request , ResponseInterface $response)

    {

        if (!isset($_SESSION['user'])){

            $req11= $this->container->pdo->prepare('select * from ville');
            $req11->execute();
            $result21=$req11->fetchAll();
            
            $this->container->view->render($response,'layouts/InscriptionUser.twig',["req"=>$result21]);

        }

    else{

        $this->render($response,'layouts/home.twig');

    }
    
}
public function  getGestionAnnonceurs(RequestInterface $request , ResponseInterface $response)

{
    if (isset($_SESSION['user'])){
            
            
        if($_SESSION['user']=="admin"){
            $test=$this->TestConnection();
            $testAd=2;
            if($test){
                $testAd=$this->TestAdmin();
            }
                    //Requete INFO ANNONCeuers :
                    $req1 = $this->container->pdo->prepare('SELECT u.id,u.username , u.email , u.adresse,u.telephone,v.ville FROM User u,ville v ,UserEst ue where v.id=u.idVille and ue.idUser=u.id and ue.idRole=2 ORDER BY u.id desc');
            $req1->execute();
            $result2=$req1->fetchAll();
            $req2 = $this->container->pdo->prepare('SELECT idUser , count(*) FROM Annonce group by  idUser ORDER BY idUser desc');

            $req2->execute();

            $result3=$req2->fetchAll();
       $do=isset($_GET['do']) ? $_GET['do'] : "";
        if($do=="delete"){
            $User=isset($_GET['idUser']) && is_numeric($_GET['idUser']) ? intval($_GET['idUser']) : 0 ;
            $requet1=$this->container->pdo->prepare('Delete FROM User where id=:idUser');
            $requet1->execute(array(':idUser' => $User));
            $req1 = $this->container->pdo->prepare('SELECT u.id,u.username , u.email , u.adresse,u.telephone,v.ville FROM User u,ville v ,UserEst ue where v.id=u.idVille and ue.idUser=u.id and ue.idRole=2');
            $req1->execute();
            $result2=$req1->fetchAll();
            $req2 = $this->container->pdo->prepare('SELECT idUser , count(*) FROM Annonce group by  idUser ORDER BY idUser desc');

            $req2->execute();
            $result3=$req2->fetchAll();
        }
     else if(isset($_GET['do']) && $do!="delete") {
         echo "<script>alert ('attention !!!')</script>";

     }
        $this->container->view->render($response,'layouts/GestionAnnonceurs.twig',["req"=>$result2,"session"=>$_SESSION['user'],"cnx"=>$test,"testA"=>$testAd,"req1"=>$result3]);
    }else
    return $response->withRedirect('PageUser');

    }
    else
    $this->render($response,'layouts/loginUser.twig');

}
//Post inscri :
    public  function  postInscri(RequestInterface $request , ResponseInterface $response)
    {
        if (!isset($_SESSION['user'])){
            if (isset($_POST["Unom"])){
        $params =$request->getParsedBody();
        $ville=$params["ville"];
        $unom=$params["Unom"];
        $email=$params["email"];
        $password=$params["password"];
        $adrs=$params["adresse"];
        $tele=$params["phone"];
        $req =$this->container->pdo->prepare('SELECT * FROM User where username=:name or email=:email');
        $req->execute(array(':name'=>$unom,':email'=>$email));
        $row_cnt = $req->rowCount();
        if($row_cnt<=0)
        {
        $dbquery=$this->container->pdo->prepare("INSERT INTO User (username, password, email, adresse, idVille , telephone) VALUES (:name,:password,:email,:adresse,:ville,:telephone)");
        $dbquery->execute(array(':name'=>$unom ,':password'=>$password ,':email'=>$email,':adresse'=>$adrs ,':telephone'=>$tele,':ville'=>$ville));
        $req =$this->container->pdo->prepare('SELECT * FROM User where username=:name');
        $req->execute(array(':name'=>$unom ));
        $result = $req->fetchAll();
        $dbquery2=$this->container->pdo->prepare("INSERT INTO `UserEst` (`idUser`, `idRole`) VALUES (:id, '2')");
        $dbquery2->execute(array(':id'=>$result[0][0]));
        return  $this->container->view->render($response,'layouts/loginUser.twig');
        }
        else if ( $row_cnt>0){
            echo "<script>alert('ce username ou email deja existe');</script>";
            return  $this->container->view->render($response,'layouts/InscriptionUser.twig');
        }
        }
    }
        else
        {
        echo "<script>alert('vous ne pouvez pas inscris ta deja un compte');</script>";
        return  $this->container->view->render($response,'layouts/InscriptionUser.twig');

        }
    }
}