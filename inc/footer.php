<style>
.custom-alert{
    position: fixed;
    top:25px;
    z-index: 111111;
    right:25px;
    
}
.alert-success{
    position: fixed;
    top:25px;
    z-index: 111111;
    right:25px;
}
</style>

<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4 p-4">
        <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'];?></h3>
        <p><?php echo $settings_r['site_about'];?></p>
        </div>
            <div class="col-lg-4 p-4">
            <h5 class="mb-3 fw-bold">Links</h5>
            <a href="hotel.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a> <br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a> <br>
            <a href="facalites.php" class="d-inline-block mb-2 text-dark text-decoration-none">facilities</a> <br> 
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a> <br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a>
            </div>
            <div class="col-lg-4 p-4">
            <h5 class="fw-bold">Follow us</h5>

            <?php
            if($contact_r['tw']!=''){
                echo<<< data
                <a href=" $contact_r[tw]" class="d-inline-block mb-2  text-decoration-none text-dark">
                <i class="bi bi-twitter me-1"></i> Twitter
                </a>
                <br>
                data;
            }
            ?>


                <a href="<?php echo $contact_r['fb']?>" class="d-inline-block mb-2  text-decoration-none text-dark">
                    <i class="bi bi-facebook me-1"></i> Facebook
                </a>
                <br>
                <a href="<?php echo $contact_r['insta']?>" class="d-inline-block mb-2  text-decoration-none text-dark">
                    <i class="bi bi-instagram me-1"></i> Instagram 
                </a>
            </div>
        </div>
    </div>

    <h6 class="text-center bg-dark text-white p-3 m-0 ">Hotel</h6>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <script>
        function alert(type,msg){
            let bs_class= (type=="success")? 'alert-success' : 'alert-danger';
            let element=document.createElement('div');
            element.innerHTML=`
            <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert">
                    <strong class="me-3">${msg}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            document.body.append(element);
            // setTimeout(remAlert,4000); 
        }
        // function remAlert(){
        //     document.getElementByClassName('alert')[0].remove();
        // }

    function setActive(){
        let navbar=document.getElementById('nav-bar');
        let a_tags=navbar.getElementsByTagName('a');
        let len=a_tags.length;

        for(i=0;i<len;i++){

            let file=a_tags[i].href.split('/').pop();

            let file_name=file.split('.')[0];

            if(document.location.href.indexOf(file_name)>=0){
                a_tags[i].classList.add('active');
            }
        }
    
}
    let register_form=document.getElementById('register-form');
    register_form.addEventListener('submit' , (e)=>{
        e.preventDefault();
        let data = new FormData();

        data.append('name',register_form.elements['name'].value);
        data.append('email',register_form.elements['email'].value);
        data.append('phonenum',register_form.elements['phonenum'].value);
        data.append('address',register_form.elements['address'].value);
        data.append('pincode',register_form.elements['pincode'].value);
        data.append('dob',register_form.elements['dob'].value);
        data.append('pass',register_form.elements['pass'].value);
        data.append('cpass',register_form.elements['cpass'].value);
        // data.append('profile',register_form.elements['profile'].files[0]);
        data.append('register','');

        var myModal = document.getElementById('RegisterModal');
        var modal=bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr=new XMLHttpRequest();
            xhr.open("POST","ajax/login_register.php",true);

            xhr.onload=function(){
                console.log(this.responseText);
                if(this.responseText == 'pass_mismatch'){
                    alert('error',"Password Mismatch");
                }
                else if(this.responseText == 'email_already'){
                    alert('error',"Email is already registered!");
                }
                else if(this.responseText ==' phone_already'){
                    alert('error',"phone number is already registered!");
                }
                else if(this.responseText =='inv_img'){
                    alert('error',"Only JPG, WEBP & PNG images are allowed");
                }
                else if(this.responseText =='upd_failed'){
                    alert('error',"Image upload failed!");
                }
                else if(this.responseText =='mail_failed'){
                    alert('error',"Cannot send confirmation email! Server down!");
                }
                else if(this.responseText =='ins_failed'){
                    alert('error',"Registeration failed! Server down!");
                }
                else{
                    alert('success','Registeration successful!');
                    register_form.reset();
                }
            console.log("shero gabari");
            console.log(this.responseText);

            }
            xhr.send(data);

    });
    let login_form=document.getElementById('login-form');
    login_form.addEventListener('submit' , (e)=>{
        e.preventDefault();
        let data = new FormData();
        console.log("shero");

        data.append('email_mob',login_form.elements['email_mob'].value);
        data.append('pass',login_form.elements['pass'].value);
        data.append('login','');
        

        var myModal = document.getElementById('LoginModal');
        var modal=bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr=new XMLHttpRequest();
            xhr.open("POST","ajax/login_register.php",true);

            xhr.onload=function(){
                console.log(this.responseText);
                if(this.responseText=="inv_email_mob"){
                    alert("error","Invalid Email or Mobile Number!");
                }
                else if(this.responseText=="inactive"){
                    alert("error","Account Suspended! Please Contact Admin.");
                }
                else if(this.responseText=="invalid_pass"){
                    alert("error","Incorrect Password!");
                }
                else if(this.responseText=="rate_limit"){
                    alert("error","Too many login attempts. Please wait 10 minutes.");
                }
                else{
                    let fileurl = window.location.href.split('/').pop().split('?').shift(); 
                    if(fileurl == 'room_details.php'){
                        window.location=window.location.href;
                    }
                    else{
                        window.location=window.location.pathname;
                    }
                }
            }
            xhr.send(data);

    });
    function checkLoginToBook(status,room_id){
        if(status){
            window.location.href='confirm_booking.php?id='+room_id;
        }
        else{

            alert('error','please login to book room!');
        }
    }



setActive();
</script>