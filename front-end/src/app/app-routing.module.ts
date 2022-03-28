import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { AlbumComponent } from './album/album.component';
import { ArtistComponent } from './artist/artist.component';
import { ArtistViewComponent } from './artist/artist-view/artist-view.component';
import { Role } from './role.model';
import { AuthGuard } from './auth-guard.helper';
import { AlbumAddComponent } from './album/album-add/album-add.component';
import { AlbumEditComponent } from './album/album-edit/album-edit.component';
import { AlbumViewComponent } from './album/album-view/album-view.component';

const routes: Routes = [
  { path: '', component: ArtistComponent, canActivate: [AuthGuard] },
  { path: 'login', component: LoginComponent},
  { path: 'register', component: RegisterComponent },
  { path: 'album', component: AlbumComponent, canActivate: [AuthGuard] },
  { path: 'album/add', component: AlbumAddComponent, canActivate: [AuthGuard] },
  { path: 'album/edit/:id', component: AlbumEditComponent, canActivate: [AuthGuard] },
  { path: 'album/view/:id', component: AlbumViewComponent, canActivate: [AuthGuard] },
  { path: 'artist', component: ArtistComponent, canActivate: [AuthGuard] },
  { path: 'artist/view/:id', component: ArtistViewComponent, canActivate: [AuthGuard] },
   // otherwise redirect to home
   { path: '**', redirectTo: 'login' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
