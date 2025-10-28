<?php
class model
{

    public $conn ;

    function __construct()
    {
        //hostname uname pass dbname
        $this->conn = new mysqli('localhost', 'root', '', 'istudio');
    }

    //single table Select Function
    function select($tbl)
    {
        echo $sel = "select * from $tbl";   // query
        $run = $this->conn->query($sel);   // query run
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }

    function select_orderby($tbl, $col)
    {
        echo $sel = "select * from $tbl ORDER BY $col";   // query
        $run = $this->conn->query($sel);   // query run
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }


    function select_decending($tbl, $col)
    {
        echo $sel = "select * from $tbl ORDER By $col desc";   // query
        $run = $this->conn->query($sel);   // query run
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }

    //double table Select Function
    function double_select($tbl1, $tbl2, $col, $on)
    {
        // select * from categories join products on categories.id=product.cate_id
        echo $sel = "select $tbl1.*,$tbl2.$col from $tbl1 join $tbl2 on $on";   // query
        $run = $this->conn->query($sel);   // query run
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }


    function select_where($tbl,$arr)
    {
        $sel="select * from $tbl where 1=1";  // query continue
        $col_arr = array_keys($arr); // array(0=>"email",1=>"password")
        $value_arr = array_values($arr);
        $i=0;
        foreach($arr as $c)
        {
           $sel.=" and $col_arr[$i]='$value_arr[$i]'";
           $i++;
        }
        $run = $this->conn->query($sel);   // query run
        return $run;
        
        //$chk=$run->num_rows;  // login

        /*

        $fetch = $run->fetch_object() // if single data

        while ($fetch = $run->fetch_object()) {   // multiple data fetch
            $arr[] = $fetch;
        }
        */ 
        
    }

    // insert Function
    function insert($tbl, $arr)
    {

        $col_arr = array_keys($arr);  // array('0'=>"cate_name",'1'=>"cate_image");
        // Enclose column names in backticks to handle spaces or reserved words
        $col_arr_escaped = array_map(function($col) {
            return "`" . $col . "`";
        }, $col_arr);
        $col = implode(",", $col_arr_escaped); // `cate_name`,`cate_image`

        $value_arr = array_values($arr);  // array('0'=>"kids",'1'=>"kids.jpg");
        $value = implode("','", $value_arr); // 'kids','kids.jpg'


        // insert into categories (`cate_name`,`cate_image`) values ('kids','kids.jpg')
        $ins = "insert into $tbl ($col) values ('$value')";   // query
        $run = $this->conn->query($ins);   // query run
        return $run;
    }

	

    function delete_where($tbl,$arr)
    {
        $sel="delete from $tbl where 1=1";  // query continue
        $col_arr = array_keys($arr); // array(0=>"email",1=>"password")
        $value_arr = array_values($arr);
        $i=0;
        foreach($arr as $c)
        {
           $sel.=" and $col_arr[$i]='$value_arr[$i]'";
           $i++;
        }
        $run = $this->conn->query($sel);   // query run
        return $run;
    }
	
	
    function update($tbl, $arr, $where)
    {
        $col_arr = array_keys($arr);  // array('0'=>"cate_name",'1'=>"cate_image");
        $value_arr = array_values($arr);  // array('0'=>"kids",'1'=>"kids.jpg");

        // update customer set name='',email='' where id=5
		$upd = "update $tbl set";   // query
		$j=0;

		$count=count($arr);
		foreach($arr as $data)
		{
			if($count==$j+1)
			{
				$upd.=" $col_arr[$j]='$value_arr[$j]'";
			}
			else
			{
				$upd.=" $col_arr[$j]='$value_arr[$j]',";
				$j++;
			}
		}

		$upd.=" where 1=1";

		$wcol_arr = array_keys($where);
        $wvalue_arr = array_values($where);
        $i=0;
        foreach($where as $c)
        {
           $upd.=" and $wcol_arr[$i]='$wvalue_arr[$i]'";
           $i++;
        }
        $run = $this->conn->query($upd);   // query run
        return $run;
    }

    // Register user with password hashing and image upload
    function register_user($data, $image = null)
    {
        // Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Handle image upload
        if ($image && $image['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($image["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($image["tmp_name"]);
            if ($check !== false) {
                // Allow certain file formats
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    // Generate unique name to avoid conflicts
                    $new_name = uniqid() . "." . $imageFileType;
                    $target_file = $target_dir . $new_name;
                    if (move_uploaded_file($image["tmp_name"], $target_file)) {
                        $data['image'] = $new_name;
                    } else {
                        return false; // Upload failed
                    }
                } else {
                    return false; // Invalid file type
                }
            } else {
                return false; // Not an image
            }
        }

        // Handle language array
        if (isset($data['language']) && is_array($data['language'])) {
            $data['language'] = implode(',', $data['language']);
        }

        // Insert user
        return $this->insert('cust_signin', $data);
    }

    // Authenticate user
    function authenticate_user($email, $password)
    {
        $result = $this->select_where('cust_signin', ['Email' => $email]);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // Update user profile with optional image upload
    function update_profile($user_id, $data, $image = null)
    {
        // Handle image upload if provided
        if ($image && $image['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($image["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($image["tmp_name"]);
            if ($check !== false) {
                // Allow certain file formats
                if (in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                    // Generate unique name to avoid conflicts
                    $new_name = uniqid() . "." . $imageFileType;
                    $target_file = $target_dir . $new_name;
                    if (move_uploaded_file($image["tmp_name"], $target_file)) {
                        $data['image'] = $new_name;
                    } else {
                        return false; // Upload failed
                    }
                } else {
                    return false; // Invalid file type
                }
            } else {
                return false; // Not an image
            }
        }

        // Handle language array
        if (isset($data['Language']) && is_array($data['Language'])) {
            $data['Language'] = implode(',', $data['Language']);
        }

        // Update user
        return $this->update('cust_signin', $data, ['id' => $user_id]);
    }

}

$obj = new model;
