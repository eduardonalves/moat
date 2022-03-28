import { Component, OnInit } from '@angular/core';
import { AlbumService } from '../album.service';
import { ArtistService } from '../artist.service';
import { LoginService } from '../login.service';

@Component({
  selector: 'app-artist',
  templateUrl: './artist.component.html',
  styleUrls: ['./artist.component.css']
})
export class ArtistComponent implements OnInit {

  public artists_list: Object[] = [];
  public artist_map:any = [];
  constructor(
    private albumService:AlbumService,
    private loginService:LoginService,
    private artistService:ArtistService
  ) { 
    this.loadArtists();
   
  }
  loadArtists = () => {
    this.artist_map=[];
    this.artistService.list().subscribe(res => {
      
      this.artists_list=res;
      res.forEach((e: any)=> {
        this.artist_map.push({
          id:e.id,name:e.name
        });
      });
      
   });
  }
  logout = ():void => {
    this.loginService.logout();
  }
  ngOnInit(): void {
  }

}
