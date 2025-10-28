<?php

include_once('model.php');   // 1 load model

class control extends model
{   // 2 etends model for use of logic

    function __construct()
    {
        session_start();
        model::__construct();  // 3 call model __construct

        $path = $_SERVER['PATH_INFO'];

        switch ($path) {

            case '/index':
                include_once('index.php');
                break;

            case '/about-us':
                include_once('about-us.php');
                break;

            case '/course':
                include_once('course.php');
                break;

            case '/our-services':
                include_once('our-services.php');
                break;

            case '/contact-us':
                include_once('contact-us.php');
                break;

            case '/signup':
                if (isset($_REQUEST['submit'])) {

                    $name = $_REQUEST['fullName'];
                    $email = $_REQUEST['Email'];
                    $password = md5($_REQUEST['Password']);
                    $mobile = $_REQUEST['Mobile'];
                    $lag = implode(",", $_REQUEST['Language']); // checkbox arr to string
                    $gender = $_REQUEST['Gender'];

                    $image = $_FILES['image']['name'];

                    $path = 'assets/images/customers/' . $image;
                    $dup_img = $_FILES['Image']['tmp_name'];
                    move_uploaded_file($dup_img, $path);

                    $data = array(
                        "fullName" => $name,
                        "Email" => $email,
                        "Password" => $password,
                        "Mobile" => $mobile,
                        "Language" => $lag,
                        "Gender" => $gender,
                        "Image" => $image
                    );

                    $res = $this->insert('customer', $data);
                    if ($res) {
                        echo "<script>
                            alert('Signup Success!');
                            window.location='login';
                        </script>";
                    } else {
                        echo "Not succeess";
                    }
                }
                include_once('signup.php');
                break;

            case '/login':
                if (isset($_REQUEST['submit'])) {

                    $email = $_REQUEST['email'];
                    $password = md5($_REQUEST['password']);
                    $data = array(
                        "email" => $email,
                        "password" => $password
                    );
                    $res=$this->select_where('customer',$data);
                    $chk=$res->num_rows; 
                    if($chk==1) // 1 means true & 0 false
                    {
                        $data=$res->fetch_object(); // data fetch single
						
						if($data->status=="Unblock")
						{
							
							//CREATE SESSION
							$_SESSION['u_name']=$data->name;
							$_SESSION['u_email']=$data->email;
							$_SESSION['u_id']=$data->id;


							echo "<script>
								alert('Login Success!');
								window.location='index';
							</script>";
						}
						else
						{
							echo "<script>
                            alert('Login Failed due to Blocked Account so Contact us!');
                            window.location='login';
							</script>";
						}
                    }
                    else
                    {
                        echo "<script>
                            alert('Login Failed due to wrong credential!');
                            window.location='login';
                        </script>";
                    }
                }
                include_once('login.php');
                break;

                case '/user_logout':
                
                    unset($_SESSION['u_id']);
                    unset($_SESSION['u_name']);
                    unset($_SESSION['u_email']);

                    //session_destroy();
                     echo "<script>
                            alert('Logout Success!');
                            window.location='index';
                        </script>";
                break;
				
				
				case '/user_profile':
                $arr=array("id"=>$_SESSION['u_id']);
				$run=$this->select_where('customer',$arr);
				$fetch = $run->fetch_object(); 
				include_once('user_profile.php');
                break;
				
				case '/edit_profile':
				if (isset($_REQUEST['edit_customer'])) {
                    $id = $_REQUEST['edit_customer'];
                    $where = array("id" => $id);
                    $res = $this->select_where('customer', $where);
					$fetch = $res->fetch_object();
					
					 if (isset($_REQUEST['save'])) {

						$name = $_REQUEST['name'];
						$email = $_REQUEST['email'];
						$mobile = $_REQUEST['mobile'];
						$lag = implode(",", $_REQUEST['lag']); // checkbox arr to string
						$gender = $_REQUEST['gender'];

						if($_FILES['image']['size']>0)
						{
							// delete image
							$old_img=$fetch->image;
							unlink('assets/images/customers/' . $old_img);

							
							$image = $_FILES['image']['name'];
							$path = 'assets/images/customers/' . $image;
							$dup_img = $_FILES['image']['tmp_name'];
							move_uploaded_file($dup_img, $path);
							
							$data = array(
								"name" => $name,
								"email" => $email,
								"mobile" => $mobile,
								"lag" => $lag,
								"gender" => $gender,
								"image" => $image
							);
							$res = $this->update('customer', $data, $where);
							if ($res) {
								echo "<script>
									alert('Updated Success!');
									window.location='user_profile';
								</script>";
							}
						}
						else
						{
							$data = array(
								"name" => $name,
								"email" => $email,
								"mobile" => $mobile,
								"lag" => $lag,
								"gender" => $gender
							);
							$res = $this->update('customer', $data, $where);
							if ($res) {
								echo "<script>
									alert('Updated Success!');
									window.location='user_profile';
								</script>";
							}
						}
							
							
					}
					
                }
				include_once('edit_profile.php');
                break;

        }
    }
}

$obj = new control;
