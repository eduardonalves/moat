import { Component, OnInit } from '@angular/core';
import { ArtistService } from 'src/app/artist.service';
import { FormGroup, FormControl,Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { first } from 'rxjs/operators';
import { Album } from 'src/app/album.model';
import { AlbumService } from 'src/app/album.service';

@Component({
  selector: 'app-album-edit',
  templateUrl: './album-edit.component.html',
  styleUrls: ['./album-edit.component.css']
})
export class AlbumEditComponent implements OnInit {
  public artists:any = [];

  public formAlbum: FormGroup;
  public album;
  public loading;
  public error;
  public params:any;
  public current_album:any;
  constructor(
    private artistService:ArtistService,
    private albumService:AlbumService,
    private router: Router,
    private route: ActivatedRoute   
    ) {
    this.route.params.subscribe( params => this.params=params );
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

    this.albumService.view(this.params.id).subscribe(res => {
      if(typeof res.data != 'undefined'){
        this.current_album=res.data;
        this.formAlbum.patchValue({
          album_name: res.data.album_name,
          year: res.data.year,
          artist_id: res.data.artist_id,
        })
      }
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
    this.album.id =this.params.id;
   // console.log(this.album);
    let test = this.checkforErrors();
    if(test){
      this.albumService.update(this.album)
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
                console.log('erro')
            }
        });
    }
  }

  ngOnInit(): void {
  }

}
