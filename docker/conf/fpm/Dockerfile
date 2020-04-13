FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y libldap2-dev wget sshpass && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

RUN apt-get update && apt-get install -y openssh-server && systemctl enable ssh && echo 'root' > /pass
RUN ssh-keygen -t rsa -f /root/.ssh/id_rsa -P '' && cp -r /root/.ssh /var/www 
RUN chown www-data:www-data /var/www/.ssh && chown www-data:www-data /var/www/.ssh/*

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv ./composer.phar /usr/local/bin/composer 

#CMD ["php-fpm"]
ENTRYPOINT ["php-fpm"]

#pub
#ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDkHII/FKbMpoYPctRY7PO0ZnkNncYdjXmwzP/i8Hjbu1+FHnG3VD5AMX8AKsCRpCJaWyKU3hWDX/P7lw7OuBbWY+evfTnc8nlOd47eO3rMSTaHgnVLe2S7z8BV4wOF4hCvjJODXPhpSXiJeQxsVxWg4RtJfUfLKWnr6pBYoI38CERAVaHasKwfg4bpSO+lynonh4h/ewW+NSOrweoJ6nJXGfD8fK1b8LXhjtz2e7OwyR8WKtVybcfcKkwXFwUdhpnZ+qxrxgORZ2CLHY9XZh6s/oQq+AX15LGDd3V2TozRIL0kKKNiWBPIVuVOQ++3gsNxqbDPWgwNO1tIt5A+fQBT root@8a076ff5be7d

#priv
# -----BEGIN OPENSSH PRIVATE KEY-----
# b3BlbnNzaC1rZXktdjEAAAAABG5vbmUAAAAEbm9uZQAAAAAAAAABAAABFwAAAAdzc2gtcn
# NhAAAAAwEAAQAAAQEA5ByCPxSmzKaGD3LUWOzztGZ5DZ3GHY15sMz/4vB427tfhR5xt1Q+
# QDF/ACrAkaQiWlsilN4Vg1/z+5cOzrgW1mPnr3053PJ5TneO3jt6zEk2h4J1S3tku8/AVe
# MDheIQr4yTg1z4aUl4iXkMbFcVoOEbSX1Hyylp6+qQWKCN/AhEQFWh2rCsH4OG6Ujvpcp6
# J4eIf3sFvjUjq8HqCepyVxnw/HytW/C14Y7c9nuzsMkfFirVcm3H3CpMFxcFHYaZ2fqsa8
# YDkWdgix2PV2YerP6EKvgF9eSxg3d1dk6M0SC9JCijYlgTyFblTkPvt4LDcamwz1oMDTtb
# SLeQPn0AUwAAA8i5FL/BuRS/wQAAAAdzc2gtcnNhAAABAQDkHII/FKbMpoYPctRY7PO0Zn
# kNncYdjXmwzP/i8Hjbu1+FHnG3VD5AMX8AKsCRpCJaWyKU3hWDX/P7lw7OuBbWY+evfTnc
# 8nlOd47eO3rMSTaHgnVLe2S7z8BV4wOF4hCvjJODXPhpSXiJeQxsVxWg4RtJfUfLKWnr6p
# BYoI38CERAVaHasKwfg4bpSO+lynonh4h/ewW+NSOrweoJ6nJXGfD8fK1b8LXhjtz2e7Ow
# yR8WKtVybcfcKkwXFwUdhpnZ+qxrxgORZ2CLHY9XZh6s/oQq+AX15LGDd3V2TozRIL0kKK
# NiWBPIVuVOQ++3gsNxqbDPWgwNO1tIt5A+fQBTAAAAAwEAAQAAAQEAz/qyQiNpJURbDLDM
# rTt1w7B+hIyqen1oS2vNjrNj7iu7npqwYc98Znj6a0OPifqVm75mHEcUZFDTGjuTM6UipV
# w3fIh3flzRf1qAt1yRzLqf7hNjMGwT3y0/Fs/BgYspXXWVdXsJvq1PKkBktE7+GE3F3E5O
# bAyZV5DpBPV2HygNfhl3niKbD2lYddufn/ilDJpUI8OqmXAeKlsVVtjIroI+e36ohxw9Wm
# MFXuS5y7GNefBzsU0i0q1LYyJNYB0mjc8Y4MwkzBTmPKnI71QixAMMNMPjZ/vItfIoawXR
# 88drOoPGxKbbER9X2B40TlUjdJ5zp+7uuNf7i7nOzIENUQAAAIEA6yTVlxiyE9aRQkdmRC
# OtjUBD5PTj+LfPwKaoDxqgxf/z4Aw2utP/nI3nddtkk4orUcTHdsAyUQMZ4N6YkalgACWR
# L6Whclij6wdbiaMgMY/fx+1OB/6p06AsTgEQluJLm6AVoKh19haklSWtZoVajC0Qx9y0fN
# 0jPcnYemsWIP8AAACBAPkR5RVMLkJOtzf6ml+QE20I9wGrXtMe0zFJl336lAlbZ+ft1RPf
# 6G9f/bVIkiRMvTUVuowvhOgoiTbWSSux7dqjpMXKGyGLJlY3Rju3n2ryD0aedRmkakRmiN
# hZsm7WsFCyh5Z4HC8CJw3a31Ddqgh6hH5NgbTHqsxAEFhN3MqJAAAAgQDqdVPxp7RXfvDA
# TGaSVN+DGpDQmGV3Yp2BLnqS/MXrcGD3wzuzAulp4QHAd2/f1vRQvdKBYwVw5/YksAnvOc
# JnlecY6IRWuT64nn/STDKbLAT/3UDEuSluyhHm52Fwe5rjvH41k1HlDpkycogdOQdxaMPz
# dBXt4ywxZbYG8GQM+wAAABFyb290QDhhMDc2ZmY1YmU3ZA==
# -----END OPENSSH PRIVATE KEY-----

#known_hosts
# |1|tPEjVgM7FU6+cndW6jbpzic9Jvs=|DMW7J/2gnpDCAiM/fmXoQZwDxbg= ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlzdHAyNTYAAABBBEpi+t/1EHrmNzJoDYdc/84kRTOJQ2Fn/bRwJEgnSBQeQJX+oEPQEvCf8/HgJP3tk40LQ2l/bytvR8OjMcLAXxA=