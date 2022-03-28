import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { LoginService } from './login.service';
import { User } from './user.model';
import { Role } from './role.model';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'front-end';
  user: User;

  constructor(private loginService: LoginService) {
    this.user = new User();
    this.loginService.user.subscribe(x => this.user = x);
  }
  get isAdmin() {
    return this.user && this.user.role == Role.Admin;
  }

  logout() {
      this.loginService.logout();
  }

}
