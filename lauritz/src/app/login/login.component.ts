import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  // submitted: boolean = false;
  
  // DI - Dependency injection - 
  constructor(private fb: FormBuilder) {
  }

  ngOnInit() {
    this.loginForm = this.fb.group({
      username: ['', [Validators.required, Validators.minLength(3)]],
      password: ['', Validators.required]
    });
  }

  onSubmit() {
    // this.submitted = true;
    if (this.loginForm.valid) {
      // this.submitted = false;
      console.log("Form is valid");
      // send information to the server
    } else {
      // display errors
      console.log("Form is not valid");
    }

    console.log(this.loginForm);
  }
}
