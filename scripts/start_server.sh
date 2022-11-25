
#!/bin/bash
if ! [ -x "$(command -v httpd)" ]; then systemctl start httpd24 >&2;   exit 1; fi # install apache if not already installed

