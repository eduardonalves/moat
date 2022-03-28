import { Component, OnInit } from '@angular/core';
import { RegisterService } from '../register.service';
import { User } from '../user.model';
import { FormGroup, FormControl,Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  public user : User;
  
  public formUser: FormGroup;
  public loading ;
  public submitted;
  public error;
  public error_fields;
  public username_taken;

  constructor(
    private registerService: RegisterService,
    private route: ActivatedRoute,
    private router: Router,    
  ) { 
   // alert('passou aqui');
   this.user = new User();
   this.formUser = new FormGroup({
      username: new FormControl(this.user.username, Validators.required),
      password: new FormControl(this.user.password, [Validators.required,Validators.minLength(8)]),
      confirm_password: new FormControl(this.user.password, [Validators.required,Validators.minLength(8)]),
      role: new FormControl(this.user.role, Validators.required),
      full_name: new FormControl(this.user.full_name, Validators.required),
    });
    this.loading= false;
    this.submitted=false;
    this.error='';
    this.error_fields=false;
    this.username_taken=false;
  }

  ngOnInit(): void {
  }

  validateRegister() {
    this.error='';
    this.loading= true;
    this.error_fields=false;
    this.username_taken=false;

    this.user.username=this.formUser.value.username;
    this.user.password=this.formUser.value.password;
    this.user.role=this.formUser.value.role;
    this.user.full_name=this.formUser.value.full_name;
    
    let test=this.checkforErrors();

    if(this.formUser.valid  && test==true){
      
     
      if(this.user.username !='' && this.user.password !='') {
        
        this.registerService.register(this.user)
              .pipe(first())
              .subscribe({
                  next:  (response) => {
                      // get return url from query parameters or default to home page
                      const returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
                      this.loading= false;
                      //this.router.navigateByUrl(returnUrl);
                      
                      if( typeof response.errors != 'undefined' ){
                        if(typeof response.errors.username != 'undefined'){
                          if(response.errors.username[0]=='The username has already been taken.'){
                            this.username_taken=true;
                          }
                          console.log(response.errors.username[0]);
                        }
                      }else{
                        this.router.navigate(['/login']);
                      }
                      
                      this.loading = false;
                  },
                  error: error => {
                      this.error = error;
                      this.loading = false;
                      console.log('erro')
                  }
              });
      } else {
          this.loading = false;
          this.error_fields=true;
          
      }/**/
    }
    /**/
    /*this.loginService.login(this.formUser.value.username,this.formUser.value.password).subscribe(result => {
        console.log('result is ', result);
      }, error => {
        console.log('error is ', error);
      });*/
  }
  checkforErrors() {
    

    if(this.formUser.value.password.length <= 7){
      alert('Field password must have at least 8 characters.');
      this.loading = false;
      return false;
    }else if(this.formUser.value.password != this.formUser.value.confirm_password){
      alert('Fields confirm password and password must be the same.');
      this.loading = false;
      return false;
    }else if(
      this.formUser.value.password.length =='' || 
      this.formUser.value.confirm_password=='' ||
      this.formUser.value.role_id ==''  ||
      this.formUser.value.full_name ==''
      ){
        alert('All fields are required');
        this.loading = false;
        return false;
    }else{

      return true;
    }

  }
}
