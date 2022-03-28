import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { LoginService } from './login.service';
@Injectable({ providedIn: 'root' })
export class AuthGuard implements CanActivate {
    constructor(
        private router: Router,
        private loginService: LoginService
    ) { 

    }
    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        const user = this.loginService.userValue;
        
        if (user) {
            //console.log(user);
            if (typeof user.access_token == "undefined") {
                this.router.navigate(['/login']);
                alert('Acess denied.');
            }
            // check if route is restricted by role
            if (route.data['roles'] && route.data['roles'].indexOf(user.token_type) === 'admin') {
                // role not authorised so redirect to home page
                this.router.navigate(['/']);
                return false;
            }
            
            // authorised so return true
            return true;
        }

        // not logged in so redirect to login page with the return url
        this.router.navigate(['/login'], { queryParams: { returnUrl: state.url } });
        return false;
    }
}
