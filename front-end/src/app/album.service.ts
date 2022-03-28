import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient,HttpHeaders } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { User } from './user.model';
import { Album } from './album.model';
import { environment } from 'src/environments/environment';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({providedIn: 'root'})
export class AlbumService {

  constructor( private router: Router,
    private http: HttpClient) {
  }
  

  list(): Observable<any> {
    let user = JSON.parse(localStorage.getItem('user') || '');
    let auth_token ='';
    if (typeof user.access_token != 'undefined'){
      auth_token= user.access_token
    }   

    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${auth_token}`
    })
    return this.http.get<Object[]>(`${environment.apiUrl}/api/albums/list`, { headers: headers })
  }

}
