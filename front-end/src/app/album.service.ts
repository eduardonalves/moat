import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient,HttpHeaders } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import {  Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Album } from './album.model';

@Injectable({providedIn: 'root'})
export class AlbumService {

  constructor( private router: Router,
    private http: HttpClient) {
  }
  save(album:Album ) {
    let user = JSON.parse(localStorage.getItem('user') || '');
    let auth_token ='';
    if (typeof user.access_token != 'undefined'){
      auth_token= user.access_token
    } 
    console.log(auth_token);
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${auth_token}`
    });
    let httpOptions = {
      headers: headers
    };
    return this.http.post<any>(`${environment.apiUrl}/api/albums/add`, album,httpOptions)
        .pipe(map(album => {
          console.log(user);
            return album;
        }));
  }

  update(album:Album ) {
    let user = JSON.parse(localStorage.getItem('user') || '');
    let auth_token ='';
    if (typeof user.access_token != 'undefined'){
      auth_token= user.access_token
    } 
    
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${auth_token}`
    });
    let httpOptions = {
      headers: headers
    };
    return this.http.put<any>(`${environment.apiUrl}/api/albums/edit/${album.id}`, album,httpOptions)
        .pipe(map(album => {
          
            return album;
        }));
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
    });
    return this.http.get<Object[]>(`${environment.apiUrl}/api/albums/list`, { headers: headers })
  }

  view(id:any): Observable<any> {
    let user = JSON.parse(localStorage.getItem('user') || '');
    let auth_token ='';
    if (typeof user.access_token != 'undefined'){
      auth_token= user.access_token
    }   

    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${auth_token}`
    });
    return this.http.get<Object[]>(`${environment.apiUrl}/api/albums/${id}`, { headers: headers })
  }
  delete(id:any): Observable<any> {
    let user = JSON.parse(localStorage.getItem('user') || '');
    let auth_token ='';
    if (typeof user.access_token != 'undefined'){
      auth_token= user.access_token
    }   
    
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${auth_token}`
    });
    return this.http.delete<Object[]>(`${environment.apiUrl}/api/albums/delete/${id}`, { headers: headers });

    
  }
}
