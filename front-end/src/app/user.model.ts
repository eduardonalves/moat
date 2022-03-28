import { Role } from "./role.model";
export class User {
    constructor(){
        this.username = '';
        this.password = '';
        this.confirm_password = '';
        this.token_type = '';
        this.access_token='';
        this.role='';
        this.full_name='';
    }
    public username;
    public password;
    public confirm_password;
    public token_type;
    public role;
    public access_token;
    public full_name;
}
