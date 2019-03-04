export class User {
  _id: string;
  username: string;
  password: string;
  email: string;
  firstname: string;
  lastname: string;
  phone: string;
  gender: Gender; // Male, Female
  birthDate: Date;
  
}

export enum Gender {
  Male, Female, Other
}