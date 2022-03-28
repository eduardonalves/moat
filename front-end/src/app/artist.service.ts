import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient,HttpHeaders } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import {  Observable } from 'rxjs';

@Injectable({providedIn: 'root'})
export class ArtistService {

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
    return this.http.get<Object[]>(`${environment.apiUrl}/api/artists/list`, { headers: headers })
  }
}
