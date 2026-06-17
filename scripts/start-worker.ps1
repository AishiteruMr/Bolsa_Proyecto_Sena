param(
    [string]$Queues = 'high,default,low',
    [int]$SleepSeconds = 60,
    [int]$MaxJobs = 100
)

$projectDir = Split-Path -Parent (Split-Path -Parent $PSScriptRoot)
$logDir = Join-Path $projectDir "storage\logs"
$logFile = Join-Path $logDir "queue-worker.log"

if (-not (Test-Path $logDir)) {
    New-Item -ItemType Directory -Path $logDir -Force | Out-Null
}

$date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
"[$date] 🚀 Iniciando worker de colas: $Queues" | Out-File -FilePath $logFile -Append

try {
    & php "$projectDir\artisan" queue:work database `
        --queue=$Queues `
        --max-jobs=$MaxJobs `
        --max-time=3600 `
        --sleep=3 `
        --tries=3 `
        --backoff=60 `
        2>&1 | ForEach-Object {
            $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
            "$date $_" | Out-File -FilePath $logFile -Append
            Write-Host "$date $_"
        }
}
catch {
    $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    "[$date] ❌ Error: $_" | Out-File -FilePath $logFile -Append
    Write-Host "[$date] ❌ Error: $_"
}
