import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { User } from './user.model';
import { environment } from 'src/environments/environment';

@Injectable({ providedIn: 'root' })
export class RegisterService {
  
  

  constructor( private router: Router,
    private http: HttpClient) {
  }
  register(user:User ) {
    return this.http.post<any>(`${environment.apiUrl}/api/register`, user)
        .pipe(map(user => {
          //console.log(user);
            return user;
        }));
  }
}
