import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { BsDropdownModule } from 'ngx-bootstrap/dropdown';
import { TooltipModule } from 'ngx-bootstrap/tooltip';
import { ModalModule } from 'ngx-bootstrap/modal';
import { RegisterComponent } from './register/register.component';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { ArtistComponent } from './artist/artist.component';
import { AlbumComponent } from './album/album.component';

import { AlbumAddComponent } from './album/album-add/album-add.component';
import { AlbumEditComponent } from './album/album-edit/album-edit.component';
import { AlbumViewComponent } from './album/album-view/album-view.component';
import { ArtistViewComponent } from './artist/artist-view/artist-view.component'; 

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    ArtistComponent,
    AlbumComponent,
    
    AlbumAddComponent,
         AlbumEditComponent,
         AlbumViewComponent,
         ArtistViewComponent
  ],
  imports: [
    BrowserModule,
    BsDropdownModule.forRoot(),
    TooltipModule.forRoot(),
    ModalModule.forRoot(),
    FormsModule,
    ReactiveFormsModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
