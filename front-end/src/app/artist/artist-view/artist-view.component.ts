import { Component, OnInit } from '@angular/core';
import { ArtistService } from 'src/app/artist.service';
import { FormGroup, FormControl,Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { Artist } from 'src/app/artist.model';



@Component({
  selector: 'app-artist-view',
  templateUrl: './artist-view.component.html',
  styleUrls: ['./artist-view.component.css']
})
export class ArtistViewComponent implements OnInit {

  public artists:any = [];

  public formArtist: FormGroup;
  public artist;
  public loading;
  public error;
  public params:any;
  
  public albums_map: any=[] ;

  constructor(
    private artistService:ArtistService,
    private router: Router,
    private route: ActivatedRoute   
    ) {
    this.route.params.subscribe( params => this.params=params );
    this.artist = new Artist();
    this.loading=false;
    this.error='';
    this.formArtist = new FormGroup({
      name: new FormControl(this.artist.name, Validators.required),
      id: new FormControl(this.artist.id, Validators.required)
    });
    this.artistService.list().subscribe(res => {
      this.artists =[];
      res.forEach((e: any)=> {
        
        this.artists.push({
          id:e.id,name:e.name
        });
        //console.log(this.artists);
      });
    });

    this.artistService.view(this.params.id).subscribe(res => {
      this.albums_map=[];

      if(typeof res.name != 'undefined'){
        
        this.formArtist.patchValue({
          name: res.name,
          id: res.id,
        });
        if(typeof res.albums != 'undefined'){
          res.albums.forEach((e: any)=> {
            this.albums_map.push({
              id:e.id,album_name:e.album_name,year:e.year
            });
            //console.log(this.artists);
          });
        }
        
        /*name.albums.forEach((e: any)=> {
        
          this.artists.push({
            id:e.id,name:e.name
          });
          //console.log(this.artists);
        });*/
      }
    });

  }

  ngOnInit(): void {
  }

}
