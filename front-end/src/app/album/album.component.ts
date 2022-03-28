import { Component, OnInit } from '@angular/core';
import { AlbumService } from '../album.service';
import { Album } from '../album.model';
@Component({
  selector: 'app-album',
  templateUrl: './album.component.html',
  styleUrls: ['./album.component.css']
})
export class AlbumComponent implements OnInit {

  public album_list: Object[] = [];
  public album_map:any = [];
  constructor(private albumService:AlbumService) { 
    this.albumService.list().subscribe(res => {
      
      this.album_list=res;
      res.forEach((e: any)=> {
        console.log(e);
        this.album_map.push({
          album_name:e.album_name,artist_id:e.artist_id,year:e.year,id:e.id, artist:e.artist
        });
      });
      
   });
   console.log(this.album_map);
  }

  ngOnInit(): void {
    //this.albums_list =this.albumService.list();
    
  }

}
