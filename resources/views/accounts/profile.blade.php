@extends('layouts.app')
@section('content')
<div class="profile-outer-main">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('accounts.sidebar')
            </div>

            <div class="col-sm-9">
                <div class="profile-inner-content">
                    <div class="titled-nav-header_content">
                        <h3>Profile</h3>
                    </div>
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" class="col-form-label">First Name</label>
                                <span class="help-block">This field is required.</span>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" class="col-form-label">Last Name</label>
                                <span class="help-block">This field is required. Only your last initial will show on your profile.</span>
                                <input type="text" class="form-control" id="inputPassword4" placeholder="Last Name">
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="inputCity" class="col-form-label">Address</label>
                            <span class="help-block">e.g:-123 Main St</span>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputZip" class="col-form-label">City</label>
                                <span class="help-block">e.g:-Brooklyn</span>
                                <input type="text" class="form-control" name="city">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity" class="col-form-label">State</label>
                                <span class="help-block">e.g:-NY</span>
                                <input type="text" class="form-control" name="state">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputZip" class="col-form-label">Zip</label>
                                <span class="help-block">e.g:-11201</span>
                                <input type="text" class="form-control" name="zip">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputZip" class="col-form-label">Country</label>
                                <span class="help-block">USA</span>
                                <select>
                                    <option value="zh_HK">Chinese (Hong Kong)</option>
                                    <option value="zh_TW">Chinese (Taiwan)</option>
                                    <option value="cs_CZ">Czech (Czech Republic)</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
