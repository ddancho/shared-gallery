<?php

echo <<<PAGE
    <div class="container">
        <h2 class="container__title">Account</h2>
        <form id="accountform" action="{$params['action']}" method="POST" enctype="multipart/form-data">
            <div class="container__form-group">
                <label for="name" class="container__form-label">Name</label>
                <input
                type="text"
                id="name"
                name="name"
                value="{$params['name']}"
                class="container__form-input"
                />
                <p id="acc_name_error" class="container__description-error">0</p>
            </div>
            <div class="container__form-group">
                <label for="email" class="container__form-label">Email</label>
                <input
                type="email"
                id="email"
                name="email"
                value="{$params['email']}"
                class="container__form-input"
                />
                <p id="acc_email_error" class="container__description-error">0</p>
            </div>
            <div class="container__form-group">
                <label for="password" class="container__form-label">Password</label>
                <input
                type="password"
                id="password"
                name="password"
                class="container__form-input"
                placeholder="Enter new password"
                />
                <p id="acc_password_error" class="container__description-error">0</p>
            </div>
            <div class="container__form-group">
                <label for="confirm" class="container__form-label"
                >Confirm Password</label
                >
                <input
                type="password"
                id="confirm"
                name="confirm"
                class="container__form-input"
                placeholder="Confirm your password"
                />
                <p id="acc_confirm_error" class="container__description-error">0</p>
            </div>
            <div class="container__form-group-row">
                <input type="submit" class="container__btn-submit container__btn-submit-row" name="updateAcc" value="Update Account Info" />
                <input type="submit" class="container__btn-submit container__btn-submit-row container__btn-submit-delete" name="deleteAcc" value="Delete My Account" />
            </div>
            <p id="acc_update_success" class="container__description-success">0</p>
        </form>
    </div>
  PAGE;
