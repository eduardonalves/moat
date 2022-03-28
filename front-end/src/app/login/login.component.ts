import { Component, OnInit } from '@angular/core';
import { LoginService } from '../login.service';
import { User } from '../user.model';
import { FormGroup, FormControl } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [ LoginService ]
})
export class LoginComponent implements OnInit {
  public user : User;
  
  public formUser: FormGroup;
  public loading ;
  public submitted;
  public error;
  public error_fields;

  constructor(
    private loginService: LoginService,
    private route: ActivatedRoute,
    private router: Router,    
  ) { 
   // alert('passou aqui');
   this.user = new User();
   this.formUser = new FormGroup({
      username: new FormControl(this.user.username),
      password: new FormControl(this.user.password),
      
    });
    this.loading= false;
    this.submitted=false;
    this.error='';
    this.error_fields=false;
  }

  ngOnInit(): void {
    
  }

  

  validateLogin() {
    
    this.user.username=this.formUser.value.username;
    this.user.password=this.formUser.value.password;
    this.error='';
    this.loading= true;
    this.error_fields=false;
    if(this.user.username !='' && this.user.password !='') {
      /*this.loginService.login(this.formUser.value.username,this.formUser.value.password).subscribe(result => {
        console.log('result is ', result);
      }, error => {
        console.log('error is ', error);
      });*/
      this.loginService.login(this.formUser.value.username, this.formUser.value.password)
            .pipe(first())
            .subscribe({
                next: () => {
                    // get return url from query parameters or default to home page
                    const returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
                    this.loading= false;
                    this.router.navigateByUrl(returnUrl);
                    
                },
                error: error => {
                    this.error = error;
                    this.loading = false;
                }
            });
    } else {
        this.loading = false;
        this.error_fields=true;
        
    }/**/
  }

}

