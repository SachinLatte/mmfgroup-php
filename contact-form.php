<form action="javascript:void(0);" method="post" id="contactForm" autocomplete="off">
        <div class="row" data-aos="fade-up" data-aos-duration="1200">
          <div class="col-md-6">
            <input type="text" class="form-control mt-0" id="your-name" name="your-name" placeholder="Name" required="" onkeyup="this.value=this.value.replace(/[^a-zA-Z \n\r.]+/g, '');">
          </div>
          <div class="col-md-6">
            <input type="number" class="form-control" id="your-number" name="your-number" placeholder="Mobile No" required="" onkeyup="this.value=this.value.replace(/[^0-9]+/g,'');">
          </div>
          <div class="col-md-6 mt-40">
            <input type="email" class="form-control" id="your-email" name="your-email" placeholder="Email Id" required="" pattern="[A-Za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}" onkeyup="this.value=this.value.replace(/[^a-zA-Z@.[0-9] \n\r.]+/g, '');">
          </div>
          <div class="col-md-6 mt-40">
            <input type="text" class="form-control" id="your-destionation" name="your-destionation" placeholder="City" required="" onkeyup="this.value=this.value.replace(/[^a-zA-Z \n\r.]+/g, '');">
          </div>
          <div class="col-12">
            <textarea class="form-control mt-40" id="your-message" name="your-message" rows="5" placeholder="Other Details (No. of days, people, other preferences)" required=""></textarea>
          </div>
          <div class="col-12">
            <div class="row">
              <div class="col-md-2">
                <button data-res="<?php echo $sum; ?>" type="submit" class="form-submit-btn" id="btn-contact" name="submit" value="submit">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>