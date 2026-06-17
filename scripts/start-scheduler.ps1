param(
    [int]$SleepSeconds = 60
)

$projectDir = Split-Path -Parent (Split-Path -Parent $PSScriptRoot)
$logDir = Join-Path $projectDir "storage\logs"
$logFile = Join-Path $logDir "scheduler.log"

if (-not (Test-Path $logDir)) {
    New-Item -ItemType Directory -Path $logDir -Force | Out-Null
}

$date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
"[$date] 🚀 Iniciando scheduler (cada $SleepSeconds segundos)" | Out-File -FilePath $logFile -Append

while ($true) {
    try {
        $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        $output = & php "$projectDir\artisan" schedule:run 2>&1
        "$date $output" | Out-File -FilePath $logFile -Append
        Write-Host "[$date] schedule:run ejecutado"
    }
    catch {
        $date = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
        "[$date] ❌ Error: $_" | Out-File -FilePath $logFile -Append
        Write-Host "[$date] ❌ Error: $_"
    }

    Start-Sleep -Seconds $SleepSeconds
}
