import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditSocioModalComponent } from './edit-socio-modal.component';

describe('EditSocioModalComponent', () => {
  let component: EditSocioModalComponent;
  let fixture: ComponentFixture<EditSocioModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EditSocioModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditSocioModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
