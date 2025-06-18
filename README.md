# Insecure PHP Application

**WARNING: This application is intentionally insecure and should only be used for testing and educational purposes. Do NOT deploy in production.**

## Features & Vulnerabilities
- SQL Injection (Login, Register, Search)
- Cross-Site Scripting (XSS) (Search)
- Insecure File Upload (Upload)
- Command Injection (Command Execution)
- Insecure Authentication (Login, Register)
- **Insecure Container Base Image (Ubuntu 16.04)**

## Vulnerability Map
| Vulnerability         | Location in App         | index.php Function/Page |
|----------------------|------------------------|------------------------|
| SQL Injection        | Login, Register, Search| render_login, render_register, render_search |
| XSS                  | Search                 | render_search          |
| Insecure File Upload | Upload                 | render_upload          |
| Command Injection    | Command Execution      | render_cmd             |
| Insecure Auth        | Login, Register        | render_login, render_register |
| Insecure Base Image  | Entire Container       | Dockerfile (ubuntu:16.04) |

## Insecure Docker Base Image: Ubuntu 16.04
This project uses `ubuntu:16.04` as the base image for the Docker container. Ubuntu 16.04 is end-of-life (EOL) and no longer receives security updates, making it highly vulnerable to a wide range of attacks. The image contains many unpatched system libraries and outdated packages.

### Example CVEs in Ubuntu 16.04
- CVE-2017-5753, CVE-2017-5715, CVE-2017-5754 (Spectre/Meltdown)
- CVE-2016-5195 (Dirty COW)
- CVE-2015-7547 (glibc getaddrinfo stack-based buffer overflow)
- CVE-2014-6271, CVE-2014-7169 (Shellshock)
- CVE-2016-4484 (Cryptsetup initrd root shell)
- CVE-2016-0777 (OpenSSH information leak)
- CVE-2016-2107 (OpenSSL padding oracle)
- CVE-2016-6304 (OpenSSL denial of service)
- CVE-2017-1000367 (Sudo privilege escalation)
- CVE-2016-6662 (MySQL remote root code execution)
- CVE-2016-1247 (Apache privilege escalation)
- CVE-2017-9798 (Apache Optionsbleed)

### SBOM Generation 
syft nishanb/php-demo-app:latest -o cyclonedx-json > sbom/sbom.cdx.json
syft dir:. -o cyclonedx-json > sbom/sbom-source.cdx.json


docker image = nishanb/php-demo-app:latest