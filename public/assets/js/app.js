import Swal from "sweetalert2";

// import toastr from "toastr";

// import axios from "axios";

import Swiper from "swiper";
import "swiper/css";

const swiper_post = new Swiper(".swiper-post", {
    loop: false,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    on: {
        afterInit: function () {
            document.addEventListener("DOMContentLoaded", function () {
                window.box.addEventListener("mouseenter", function () {
                    let index;
                    if (
                        window.box.querySelector(
                            ".swiper-wrapper .swiper-slide-active"
                        )
                    ) {
                        Array.from(
                            window.box.querySelector(".swiper-wrapper").children
                        ).forEach((slide) => {
                            if (
                                slide.classList.contains("swiper-slide-active")
                            ) {
                                index = Array.from(
                                    window.box.querySelector(".swiper-wrapper")
                                        .children
                                ).indexOf(slide);
                            }
                        });
                    }
                    setTimeout(() => {
                        window.box
                            .querySelector(".post-count")
                            .querySelector("*").innerText =
                            index +
                            1 +
                            " / " +
                            window.box.querySelector(".swiper-wrapper")
                                .childElementCount;
                    }, 200);
                });
            });
        },
        slideChange: function () {
            window.box
                .querySelector(".post-count")
                .querySelector("*").innerText =
                this.realIndex + 1 + " / " + this.slides.length;
        },
    },
});

document.querySelectorAll("form[action*='post']").forEach((form) => {
    if (form.getAttribute("action").endsWith("destroy")) {
        form.addEventListener("click", function (event) {
            let prevent = form.getAttribute("disabled") == "true";
            if (prevent) event.preventDefault();
            Swal.fire({
                title: "Are You Sure You Want to Delete This Post?",
                text: "You won't be able to revert this!",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                showCancelButton: true,
                confirmButtonColor: "red",
                icon: "warning",
                iconColor: "red",
                color: "orange",
            }).then((response) => {
                if (response.isConfirmed) {
                    form.setAttribute(
                        "disabled",
                        !form.getAttribute("disabled")
                    );
                    document.querySelector(".spinner-wrapper").style.display =
                        "block";
                    setTimeout(() => {
                        document.querySelector(
                            ".spinner-wrapper"
                        ).style.display = "hidden";
                        Swal.fire({
                            title: "Post deleted",
                            icon: "success",
                            confirmButtonText: "Ok!",
                        });
                    }, 3000);
                    setTimeout(() => {
                        form.submit();
                    }, 4000);
                } else if (response.isDismissed) {
                    Swal.fire({
                        title: "Post deletion cancelled!",
                        icon: "warning",
                        confirmButtonText: "Ok!",
                    });
                }
            });
        });
    }
});

document.querySelectorAll("form[action*='profile']").forEach((form) => {
    if (form.getAttribute("action").endsWith("destroy")) {
        form.addEventListener("click", function (event) {
            let try_chance = 3;
            let prevent = form.getAttribute("disabled") == "true";
            if (prevent) event.preventDefault();
            let x = () => {
                Swal.fire({
                    title: "Are You Sure You Want to Delete Your Profile?",
                    text: "You won't be able to revert this!",
                    input: "text",
                    inputLabel: `Confirm deletion by write this text to input below: "${form.getAttribute(
                        "profile-deletion-confirm-string"
                    )}"`,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel",
                    showCancelButton: true,
                    confirmButtonColor: "red",
                    icon: "warning",
                    iconColor: "red",
                }).then((response) => {
                    if (
                        response.isConfirmed &&
                        response.value ==
                            form.getAttribute("profile-deletion-confirm-string")
                    ) {
                        form.setAttribute(
                            "disabled",
                            !form.getAttribute("disabled")
                        );
                        document.querySelector(
                            ".spinner-wrapper"
                        ).style.display = "block";
                        setTimeout(() => {
                            document.querySelector(
                                ".spinner-wrapper"
                            ).style.display = "hidden";
                            Swal.fire({
                                title: "Profile deleted",
                                icon: "success",
                                confirmButtonText: "Ok!",
                            });
                        }, 5000);
                        setTimeout(() => {
                            form.submit();
                        }, 6500);
                    } else if (
                        response.isConfirmed &&
                        response.value !=
                            form.getAttribute("profile-deletion-confirm-string")
                    ) {
                        Swal.fire({
                            title: "Input Error",
                            icon: "error",
                            text: `Expected value ${form.getAttribute(
                                "profile-deletion-confirm-string"
                            )}, got ${response.value || "nothing"}`,
                            showConfirmButton: (() => {
                                if (try_chance > 1) return true;
                                return false;
                            })(),
                            confirmButtonText: "Try Again",
                            showCancelButton: true,
                            cancelButtonText: "Cancel",
                        }).then((response) => {
                            if (response.isDismissed) {
                                Swal.fire({
                                    title: "Profile deletion cancelled!",
                                    icon: "info",
                                    text: `Profile deletion cancelled!`,
                                    confirmButtonText: "Ok!",
                                });
                            } else if (
                                !response.isDismissed &&
                                try_chance > 0
                            ) {
                                try_chance--;
                                if (try_chance > 0) {
                                    x();
                                }
                            }
                        });
                    } else if (response.isDismissed) {
                        Swal.fire({
                            title: "Profile deletion cancelled!",
                            icon: "info",
                            text: `Profile deletion cancelled!`,
                            confirmButtonText: "Ok!",
                        });
                    }
                });
            };
            x();
        });
    }
});

document.querySelectorAll(".show-alert-button").forEach((button) => {
    button.addEventListener("click", function () {
        const MESSAGE = button.getAttribute("data-session-message");
        const TYPE = button.getAttribute("data-alert-type");
        Swal.fire({
            title: TYPE.charAt(0).toUpperCase() + TYPE.substring(1),
            text: MESSAGE,
            icon: TYPE,
        });
    });
});
