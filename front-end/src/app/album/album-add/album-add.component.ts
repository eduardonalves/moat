import { Component, OnInit } from '@angular/core';
import { ArtistService } from 'src/app/artist.service';
import { FormGroup, FormControl,Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { first } from 'rxjs/operators';
import { Album } from 'src/app/album.model';
import { AlbumService } from 'src/app/album.service';

@Component({
  selector: 'app-album-add',
  templateUrl: './album-add.component.html',
  styleUrls: ['./album-add.component.css']
})
export class AlbumAddComponent implements OnInit {
  public artists:any = [];

  public formAlbum: FormGroup;
  public album;
  public loading;
  public error;
  constructor(
    private artistService:ArtistService,
    private albumService:AlbumService,
    private router: Router,
    private route: ActivatedRoute   
    ) {
    this.album = new Album();
    this.loading=false;
    this.error='';
    this.formAlbum = new FormGroup({
      album_name: new FormControl(this.album.album_name, Validators.required),
      year: new FormControl(this.album.year, [Validators.required,Validators.maxLength(4)]),
      artist_id: new FormControl(this.album.artist_id, Validators.required)
    });
    this.artistService.list().subscribe(res => {
      
      res.forEach((e: any)=> {
        
        this.artists.push({
          id:e.id,name:e.name
        });
        //console.log(this.artists);
      });
    });
   }
  checkforErrors() {
    let nb= String(this.formAlbum.value.year) ;
    
    if(
      this.formAlbum.value.album_name == '' || 
      this.formAlbum.value.year == '' ||
      this.formAlbum.value.artist_id == ''
    ){
      alert('All fields are required');
      this.loading = false;
      return false;
    }else if(nb.length > 4){
      alert('Field Year must have 4 numbers.');
      this.loading = false;
      return false;
    }else{
      return true;
    }
  }
  save() {
    this.album.album_name=this.formAlbum.value.album_name;
    this.album.year=String(this.formAlbum.value.year);
    this.album.artist_id=this.formAlbum.value.artist_id;
    //console.log(this.album);
    let test = this.checkforErrors();
    if(test){
      this.albumService.save(this.album)
        .pipe(first())
        .subscribe({
            next:  (response) => {
                // get return url from query parameters or default to home page
                const returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/';
                this.loading= false;
                //this.router.navigateByUrl(returnUrl);
                
                if( typeof response.errors == 'undefined' ){
                  alert('Album was saved.');  
                  this.router.navigate(['/album']); 
                }
                
                this.loading = false;
            },
            error: error => {
                this.error = error;
                this.loading = false;
                //console.log('erro')
            }
        });
    }
  }
  ngOnInit(): void {
  }

}
