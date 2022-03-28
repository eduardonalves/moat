import { Component, OnInit } from '@angular/core';
import { AlbumService } from '../album.service';
import { Album } from '../album.model';
import { LoginService } from '../login.service';
@Component({
  selector: 'app-album',
  templateUrl: './album.component.html',
  styleUrls: ['./album.component.css']
})
export class AlbumComponent implements OnInit {

  public album_list: Object[] = [];
  public album_map:any = [];
  constructor(
    private albumService:AlbumService,
    private loginService:LoginService
  ) { 
    this.loadAlbums();
   
  }
  loadAlbums = () => {
    this.album_map=[];
    this.albumService.list().subscribe(res => {
      
      this.album_list=res;
      res.forEach((e: any)=> {
        //console.log(e);
        this.album_map.push({
          album_name:e.album_name,artist_id:e.artist_id,year:e.year,id:e.id, artist:e.artist
        });
      });
      
   });
  }
  delete = (id:any) => {
    
    if (confirm("Do you want to delet this row?") == true) {
      
      
      this.albumService.delete(id).subscribe(res => {
      
        alert("The row was deleted with success!");
        this.loadAlbums();
          
      },err =>{
          
          if(typeof err.error !='undefined'){
            
            if(err.error.message=="Unauthorized Access"){
              alert("Unauthorized Access");
            }
          }
      });
      
    } 
  }
  logout = ():void => {
    this.loginService.logout();
  }
  ngOnInit(): void {
    //this.albums_list =this.albumService.list();
    
  }

}
